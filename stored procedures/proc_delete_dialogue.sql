USE YFZZ
GO

CREATE PROCEDURE dbo.delete_dialogue
(@Id int)
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

delete Dialogue
where Id = @Id

DECLARE @Status SMALLINT
SET @Status = @@ERROR
IF @Status <> 0 
BEGIN
	-- Return error code to the calling program to indicate failure.
	PRINT 'An error occurred deleting the dialogue ' + convert(varchar(5), @Id) + '.'
	RETURN(@Status)
END
ELSE
BEGIN
	-- Return 0 to the calling program to indicate success.
	PRINT 'The dialogue ' + convert(varchar(5), @Id) + ' was deleted successfully.'
	RETURN(0)
END