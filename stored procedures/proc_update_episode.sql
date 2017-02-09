USE YFZZ
GO

CREATE PROCEDURE dbo.update_episode
(@Id int,
 @Number int = NULL,
 @Length time(7) = NULL,
 @Summary nvarchar(100) = NULL,
 @from_Anime nvarchar(100) = NULL
)
AS

if (@Id is null)
begin
	print 'Id can not be empty'
	return (1)
end

IF (SELECT COUNT(Id) FROM Episode WHERE Id = @Id) = 0
BEGIN 
	PRINT 'The episode' + convert(varchar(5), @Id) + ' does not exist.'
	RETURN (1)
END

if (@from_Anime is not null)
begin
	IF (SELECT COUNT(Name) FROM Anime WHERE Name = @from_Anime) = 0
	BEGIN 
	PRINT 'The anime' + @from_Anime + ' does not exist.'
	RETURN (1)
	END
end

if (@Number is null or @Length is null or @Summary is null or @from_Anime is null)
begin
	declare @CurrentNumber int
	declare @CurrentLength time(7)
	declare @CurrentSummary nvarchar(100)
	declare @CurrentFromAnime nvarchar(100)
	select @CurrentNumber = Number, @CurrentLength = Length, @CurrentSummary = Summary, @CurrentFromAnime = from_Anime from Episode where Id = @Id
	if (@Number is null)
	begin
		set @Number = @CurrentNumber
	end
	if (@Length is null)
	begin
		set @Length = @CurrentLength
	end
	if (@Summary is null)
	begin
		set @Summary = @CurrentSummary
	end
	if (@from_Anime is null)
	begin
		set @from_Anime = @from_Anime
	end
end

update Episode
set Number = @Number, Length = @Length, Summary = @Summary, from_Anime = @from_Anime
where Id = @Id

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred updating the episode ' + convert(varchar(5), @Id) + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The episode ' + convert(varchar(5), @Id) + ' was updated successfully.'
	RETURN(0)
END