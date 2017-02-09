USE YFZZ
GO

CREATE PROCEDURE dbo.update_anime
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

IF (SELECT COUNT(Name) FROM Anime WHERE Name = @Name) = 0
BEGIN 
	PRINT 'The anime' + @Name + ' does not exist.'
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

if (@PDate is null or @Summary is null or @Produced_by is null or @Directed_by is null)
begin
	declare @CurrentPDate date
	declare @CurrentSummary nvarchar(200)
	declare @CurrentProduced_by nvarchar(15)
	declare @CurrentDirected_by nvarchar(50)
	select @CurrentPDate = Publish_date, @CurrentSummary = Summary, @CurrentProduced_by = Produced_by, @CurrentDirected_by = Directed_by 
	from Anime where Name = @Name
	if (@PDate is null)
	begin
		set @PDate = @CurrentPDate
	end
	if (@Summary is null)
	begin
		set @Summary = @CurrentSummary
	end
	if (@Produced_by is null)
	begin
		set @Produced_by = @CurrentProduced_by
	end
	if (@Directed_by is null)
	begin
		set @Directed_by = @CurrentDirected_by
	end
end

update Anime
set Publish_date = @PDate, Summary = @Summary, Produced_by = @Produced_by, Directed_by = @Directed_by
where Name = @Name

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred updating the anime ' + @Name + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The anime ' + @Name + ' was updated successfully.'
	RETURN(0)
END