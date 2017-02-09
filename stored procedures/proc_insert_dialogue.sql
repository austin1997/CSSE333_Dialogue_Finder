USE YFZZ
GO

CREATE PROCEDURE dbo.insert_dialogue
(@Id int,
 @Time time(7) = NULL,
 @Content_JP nvarchar(80) = NULL,
 @Content_CHN nvarchar(50) = NULL,
 @Episode_id int = NULL
)
AS

if (@Id is null)
begin
	print 'Id can not be empty'
	return (1)
end

IF (SELECT COUNT(Id) FROM Dialogue WHERE Id = @Id) > 0
BEGIN 
	PRINT 'The dialogue' + convert(varchar(5), @Id) + ' already exists.'
	RETURN (1)
END

if (@Episode_id is not null)
begin
	IF (SELECT COUNT(Id) FROM Episode WHERE Id = @Episode_id) = 0
	BEGIN 
	PRINT 'The episode' + convert(varchar(5), @Episode_id) + ' does not exist.'
	RETURN (1)
	END
end

insert Dialogue (Id, Time, Content_JP, Content_CHN, Episode_id)
values (@Id, @Time, @Content_JP, @Content_CHN, @Episode_id)

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred inserting the dialogue ' + convert(varchar(5), @Id) + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The dialogue ' + convert(varchar(5), @Id) + ' was inserted successfully.'
	RETURN(0)
END
