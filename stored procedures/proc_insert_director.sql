USE YFZZ
GO

CREATE PROCEDURE dbo.insert_director
(@Name nvarchar(50),
 @BDate date = NULL,
 @Gender char(1),
 @Info nvarchar(100) = NULL
)
AS

IF (@Name is null)
begin
	print 'Name can not be empty'
	return (1)
end

if (@Gender is null)
begin 
	print 'Gender can not be empty'
	return (1)
end

if (@Gender <> 'F' or @Gender <> 'M')
begin
	print 'Gender has to be F or M'
	return (1)
end

IF (SELECT COUNT(Name) FROM Director WHERE Name = @Name) > 0
BEGIN 
	PRINT 'The director' + @Name + ' already exists.'
	RETURN (1)
END

insert into Director (Name, Birthday, Gender, Info)
values (@Name, @BDate, @Gender, @Info)

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred inserting the director ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The director ' + @Name + ' was inserted successfully.'
	RETURN(0)
END