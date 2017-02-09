USE YFZZ
GO

CREATE PROCEDURE dbo.insert_anime
(@Name nvarchar(100),
 @PDate date = NULL,
 @Summary nvarchar(200) = NULL,
 @Produced_by nvarchar(15) = NULL,
 @Directed_by nvarchar(50) = NULL
)
AS

IF (@Name is null)
begin
	print 'Name can not be empty'
	return (1)
end

IF (SELECT COUNT(Name) FROM Anime WHERE Name = @Name) > 0
BEGIN 
	PRINT 'The anime' + @Name + ' already exists.'
	RETURN (1)
END

if (@Produced_by is not null)
begin
	IF (SELECT COUNT(Name) FROM Company WHERE Name = @Produced_by) = 0
	BEGIN 
	PRINT 'The company' + @Produced_by + ' does not exist.'
	RETURN (1)
	END
end

if (@Directed_by is not null)
begin
	IF (SELECT COUNT(Name) FROM Director WHERE Name = @Directed_by) = 0
	BEGIN 
	PRINT 'The director' + @Directed_by + ' does not exist.'
	RETURN (1)
	END
end

insert Anime (Name, Publish_date, Summary, Produced_by, Directed_by)
values (@Name, @PDate, @Summary, @Produced_by, @Directed_by)

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred inserting the anime ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The anime ' + @Name + ' was inserted successfully.'
	RETURN(0)
END