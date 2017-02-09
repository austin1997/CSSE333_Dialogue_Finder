USE YFZZ
GO

CREATE PROCEDURE dbo.update_character
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

IF (SELECT COUNT(Id) FROM Character WHERE Id = @Id) = 0
BEGIN 
	PRINT 'The character' + convert(varchar(5), @Id) + ' does not exist.'
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

if (@Name is null or @BDate is null or @Info is null or @Acted_by is null or @Name_CHN is null)
begin
	declare @CurrentName nvarchar(50)
	declare @CurrentBDate date
	declare @CurrentInfo nvarchar(1000)
	declare @CurrentActedBy nvarchar(50)
	declare @CurrentNameCHN nvarchar(50)
	select @CurrentName = Name, @CurrentBDate = Birthday, @CurrentInfo = Info, @CurrentActedBy = Acted_by, @CurrentNameCHN = Name_CHN from Character where Id = @Id
	if (@Name is null)
	begin
		set @Name = @CurrentName
	end
	if (@BDate is null)
	begin
		set @BDate = @CurrentBDate
	end
	if (@Info is null)
	begin
		set @Info = @CurrentInfo
	end
	if (@Acted_by is null)
	begin
		set @Acted_by = @CurrentActedBy
	end
	if (@Name_CHN is null)
	begin
		set @Name_CHN = @CurrentNameCHN
	end
end

update Character
set Name = @Name, Birthday = @BDate, Info = @Info, Acted_by = @Acted_by, Name_CHN = @Name_CHN
where Id = @Id

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred updating the character ' + convert(varchar(5), @Id) + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The character ' + convert(varchar(5), @Id) + ' was updated successfully.'
	RETURN(0)
END