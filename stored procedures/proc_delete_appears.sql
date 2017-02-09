USE YFZZ
GO

CREATE PROCEDURE dbo.delete_appears
(@Character_id int,
 @Episode_id int
)
AS

if (@Character_id is null)
begin
	print 'Character_id can not be empty.'
	return (1)
end

if (@Episode_id is null)
begin
	print 'Episode_id can not be empty.'
	return (1)
end

IF (SELECT COUNT(*) FROM Appears WHERE Character_id = @Character_id and Episode_id = @Episode_id) = 0
BEGIN 
	PRINT 'The record where character ' + convert(varchar(5), @Character_id) + ' appears in episode ' + convert(varchar(5), @Episode_id) + ' does not exist.'
	RETURN (1)
END

delete Appears
where Character_id = @Character_id and Episode_id = @Episode_id

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred deleting the record where character ' + convert(varchar(5), @Character_id) + ' appears in episode ' + convert(varchar(5), @Episode_id) + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The record where character ' + convert(varchar(5), @Character_id) + ' appears in episode ' + convert(varchar(5), @Episode_id) + ' was deleted successfully.'
	RETURN(0)
END
