USE YFZZ
GO

CREATE PROCEDURE dbo.delete_anime
(@Name nvarchar(100))
AS

IF (@Name is null)
begin
	print 'Name can not be empty'
	return (1)
end

IF (SELECT COUNT(Name) FROM Anime WHERE Name = @Name) = 0
BEGIN 
	PRINT 'The anime' + @Name + ' does not exist.'
	RETURN (1)
END

delete Anime
where Name = @Name

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred deleting the anime ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The anime ' + @Name + ' was deleted successfully.'
	RETURN(0)
END