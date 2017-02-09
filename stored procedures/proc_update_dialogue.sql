USE YFZZ
GO

CREATE PROCEDURE dbo.update_dialogue
(@Id int,
 @Time time(7) = NULL,
 @Content_JP nvarchar(80) = NULL,
 @Content_CHN nvarchar(50) = NULL,
 @Episode_id int = NULL
)
AS

if (@Id is null)
begin
	print 'Id can not be empty'
	return (1)
end

IF (SELECT COUNT(Id) FROM Dialogue WHERE Id = @Id) = 0
BEGIN 
	PRINT 'The dialogue' + convert(varchar(5), @Id) + ' does not exist.'
	RETURN (1)
END

if (@Episode_id is not null)
begin
	IF (SELECT COUNT(Id) FROM Episode WHERE Id = @Episode_id) = 0
	BEGIN 
	PRINT 'The episode' + convert(varchar(5), @Episode_id) + ' does not exist.'
	RETURN (1)
	END
end

if (@Time is null or @Content_JP is null or @Content_CHN is null or @Episode_id is null)
begin
	declare @CurrentTime time(7)
	declare @CurrentContentJP nvarchar(80)
	declare @CurrentContentCHN nvarchar(50)
	declare @CurrentEpisodeID int
	select @CurrentTime = Time, @CurrentContentJP = Content_JP, @CurrentContentCHN = Content_CHN, @CurrentEpisodeID = Episode_id from Dialogue where Id = @Id
	if (@Time is null)
	begin
		set @Time = @CurrentTime
	end
	if (@Content_JP is null)
	begin
		set @Content_JP = @CurrentContentJP
	end
	if (@Content_CHN is null)
	begin
		set @Content_CHN = @CurrentContentCHN
	end
	if (@Episode_id is null)
	begin
		set @Episode_id = @CurrentEpisodeID
	end
end

update Dialogue
set Time = @Time, Content_JP = @CurrentContentJP, Content_CHN = @CurrentContentCHN, Episode_id = @Episode_id
where Id = @Id

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred updating the dialogue ' + convert(varchar(5), @Id) + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The dialogue ' + convert(varchar(5), @Id) + ' was updated successfully.'
	RETURN(0)
END