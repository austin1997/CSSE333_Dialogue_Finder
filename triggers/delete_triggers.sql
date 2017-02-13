use YFZZ
go

create trigger dbo.Episode_Deleted
on dbo.Episode
for delete
as

select * from deleted