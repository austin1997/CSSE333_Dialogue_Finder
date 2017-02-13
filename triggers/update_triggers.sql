use YFZZ
go

create trigger dbo.Episode_Update
on dbo.Episode
for update
as

if update (Id)
begin
	raiserror ('Transaction cannot be processed.\
			***** The Id of the Episode cannot be modified.',10,1)
	rollback transaction
end

if update (from_Anime)
begin
	raiserror ('Transaction cannot be processed.\
			***** The from_Anime of the Episode cannot be modified.',10,1)
	rollback transaction
end
