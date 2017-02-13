use YFZZ
go

create trigger dbo.Episode_Insert
on dbo.Episode
for insert
as

select * from inserted