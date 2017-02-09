USE YFZZ
GO

CREATE PROCEDURE dbo.update_appears
(@Character_id int = NULL,
 @Episode_id int = NULL
)
AS

if (@Character_id is not null)
begin
	IF (SELECT COUNT(Id) FROM Character WHERE Id = @Character_id) = 0
	BEGIN 
	PRINT 'The character' + convert(varchar(5), @Character_id) + ' does not exist.'
	RETURN (1)
	END
end

if (@Episode_id is not null)
begin
	IF (SELECT COUNT(Id) FROM Episode WHERE Id = @Episode_id) = 0
	BEGIN 
	PRINT 'The episode' + convert(varchar(5), @Episode_id) + ' does not exist.'
	RETURN (1)
	END
end

IF (SELECT COUNT(*) FROM Appears WHERE Character_id = @Character_id and Episode_id = @Episode_id) = 0
BEGIN 
	PRINT 'The record where character ' + convert(varchar(5), @Character_id) + ' appears in episode ' + convert(varchar(5), @Episode_id) + ' does not exist.'
	RETURN (1)
END

if (@Character_id is null or @Episode_id is null)
begin
	print 'Character_id and Episode_id are both required.'
	return (1)
end
else
begin
	print 'Since the combination of the only two columns is the primary key of the table, an update is suggested to be used a delete followed by an insert'
	return (1)
end