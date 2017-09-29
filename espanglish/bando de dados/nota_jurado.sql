CREATE VIEW `nota_jurado` AS
select
*
from
paises as p
INNER JOIN barracas as b on p.codigo = b.paise_id
INNER JOIN palcos as pa on p.codigo = pa.paise_id
order by paises