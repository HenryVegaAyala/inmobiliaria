DROP FUNCTION IF EXISTS pa_liquidacion_groupcobranza (character varying, smallint, smallint);

CREATE FUNCTION pa_liquidacion_groupcobranza
(
	IN idproyecto character varying,
	IN anho smallint,
	IN mes smallint,
	OUT nombremes character varying,
	OUT numeromes integer,
	OUT importe numeric
)
RETURNS SETOF record 
AS $BODY$
BEGIN

	RETURN QUERY SELECT b.tp_nombre, b.tp_numero, SUM(COALESCE(cob.td_valorconcepto, 0))
	FROM tp_mes AS b 
		 LEFT JOIN td_conceptoscobranza AS cob ON b.tp_numero = cob.tm_per_mes AND cob.tm_idproyecto = idproyecto AND cob.tm_per_anho = anho AND cob.Activo = 1
	GROUP BY b.tp_nombre, b.tp_numero ORDER BY b.tp_numero;
END
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION pa_liquidacion_groupcobranza(character varying, smallint, smallint)
  OWNER TO postgres;	