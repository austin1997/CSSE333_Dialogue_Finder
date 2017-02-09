USE YFZZ
GO

CREATE PROCEDURE dbo.delete_artist
(@Name nvarchar(50))
AS

IF (@Name is null)
begin
	print 'Name can not be empty'
	return (1)
end

IF (SELECT COUNT(Name) FROM Artist WHERE Name = @Name) = 0
BEGIN 
	PRINT 'The artist' + @Name + ' does not exist.'
	RETURN (1)
END

delete Artist
where Name = @Name

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred deleting the artist ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The artist ' + @Name + ' was deleted successfully.'
	RETURN(0)
END