USE YFZZ
GO

CREATE PROCEDURE dbo.insert_character
(@Id int,
 @Name nvarchar(50) = NULL,
 @BDate date = NULL,
 @Info nvarchar(1000) = NULL,
 @Acted_by nvarchar(50) = NULL,
 @Name_CHN nvarchar(50) = NULL
)
AS

if (@Id is null)
begin
	print 'Id can not be empty'
	return (1)
end

IF (SELECT COUNT(Id) FROM Character WHERE Id = @Id) > 0
BEGIN 
	PRINT 'The character' + convert(varchar(5), @Id) + ' already exists.'
	RETURN (1)
END

if (@Acted_by is not null)
begin
	IF (SELECT COUNT(Name) FROM Artist WHERE Name = @Acted_by) = 0
	BEGIN 
	PRINT 'The artist' + @Acted_by + ' does not exist.'
	RETURN (1)
	END
end

insert Character (Id, Name, Birthday, Info, Acted_by, Name_CHN)
values (@Id, @Name, @BDate, @Info, @Acted_by, @Name_CHN)

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred inserting the character ' + convert(varchar(5), @Id) + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The character ' + convert(varchar(5), @Id) + ' was inserted successfully.'
	RETURN(0)
END