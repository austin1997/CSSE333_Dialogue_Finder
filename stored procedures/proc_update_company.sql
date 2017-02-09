USE YFZZ
GO

CREATE PROCEDURE dbo.update_company
(@Name nvarchar(15),
 @Date date = NULL,
 @Website nvarchar(20) = NULL
)
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

IF (@Date = NULL OR @Website = NULL)
BEGIN
	DECLARE @CurrentDate DATE
	DECLARE @CurrentWebsite nvarchar(20)
	SELECT @CurrentDate = Date_establish, @CurrentWebsite = Website FROM Company WHERE Name = @Name
	IF (@Date = NULL)
	BEGIN
		SET @Date = @CurrentDate
	END
	IF (@Website = NULL)
	BEGIN
		SET @Website = @CurrentWebsite
	END
END

UPDATE dbo.Company
SET Date_establish = @Date, Website = @Website
WHERE Name = @Name

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred updating the company ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The company ' + @Name + ' was updated successfully.'
	RETURN(0)
END
