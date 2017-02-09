USE YFZZ
GO

CREATE PROCEDURE dbo.insert_company
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

IF (SELECT COUNT(Name) FROM Company WHERE Name = @Name) > 0
BEGIN 
	PRINT 'The company' + @Name + ' already exists.'
	RETURN (1)
END

INSERT INTO Company (Name, Date_establish, Website)
VALUES (@Name, @Date, @Website)

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred inserting the company ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The company ' + @Name + ' was inserted successfully.'
	RETURN(0)
END