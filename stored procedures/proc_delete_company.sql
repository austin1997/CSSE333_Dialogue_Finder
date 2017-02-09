USE YFZZ
GO

CREATE PROCEDURE dbo.delete_company
(@Name nvarchar(15))
AS

IF(@Name IS NULL)
BEGIN
	PRINT 'Name can not be empty.'
	RETURN (1)
END

IF (SELECT COUNT(Name) FROM Company WHERE Name = @Name) = 0
BEGIN 
	PRINT 'The company' + @Name + ' does not exist.'
	RETURN (1)
END

DELETE dbo.Company
WHERE Name = @Name

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred deleting the company ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The company ' + @Name + ' was deleted successfully.'
	RETURN(0)
END