USE YFZZ
GO

CREATE PROCEDURE dbo.delete_director
(@Name nvarchar(50))
AS

IF (@Name is null)
begin
	print 'Name can not be empty'
	return (1)
end

IF (SELECT COUNT(Name) FROM Director WHERE Name = @Name) = 0
BEGIN 
	PRINT 'The director' + @Name + ' does not exist.'
	RETURN (1)
END

delete Director
where Name = @Name

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred deleting the director ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The director ' + @Name + ' was deleted successfully.'
	RETURN(0)
END