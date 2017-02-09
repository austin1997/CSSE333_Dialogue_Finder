USE YFZZ
GO

CREATE PROCEDURE dbo.update_director
(@Name nvarchar(50),
 @BDate date = NULL,
 @Gender char(1) = NULL,
 @Info nvarchar(100) = NULL
)
AS

IF (@Name is null)
begin
	print 'Name can not be empty'
	return (1)
end

if (@Gender is not null)
begin
	if (@Gender <> 'F' or @Gender <> 'M')
	begin
		print 'Gender has to be F or M'
		return (1)
	end
end

IF (SELECT COUNT(Name) FROM Director WHERE Name = @Name) = 0
BEGIN 
	PRINT 'The director' + @Name + ' does not exist.'
	RETURN (1)
END

if (@BDate is null or @Gender is null or @Info is null)
begin
	declare @CurrentBDate date
	declare @CurrentGender char(1)
	declare @CurrentInfo nvarchar(100)
	select @CurrentBDate = Birthday, @CurrentGender = Gender, @CurrentInfo = Info from Director where Name = @Name
	if (@BDate is null)
	begin
		set @BDate = @CurrentBDate
	end
	if (@Gender is null)
	begin
		set @Gender = @CurrentGender
	end
	if (@Info is null)
	begin
		set @Info = @CurrentInfo
	end
end

update Director
set Birthday = @CurrentBDate, Gender = @CurrentGender, Info = @CurrentInfo
where Name = @Name

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred updating the director ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The director ' + @Name + ' was updated successfully.'
	RETURN(0)
END