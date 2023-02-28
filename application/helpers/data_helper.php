<?php

/**
 * Classe que manipula datas
 * @author Bruno C�sar Bulnes
 * @see Sistema Ouvidoria, Sistema BI.
 */

/**
 * Adiciona dias a uma determinada data
 * @param string $data Data no formato dd/mm/AAAA
 * @param integer $dias Dias para serem adicionados
 * @return string Data somada aos dias passados como par�metros
 */
function Adiciona_Dias_A_Data($data, $dias)
{
	return date("d/m/Y", mktime(0, 0, 0, Extrair_Mes($data), Extrair_Dia($data) + $dias, Extrair_Ano($data)));
}

/**
 * Subtrai dias a uma determinada data
 * @param string $data Data no formato dd/mm/AAAA
 * @param integer $dias Dias para serem subtraidos
 * @return string Data subtraida aos dias passados como par�metros
 */
function Subtrai_Dias_A_Data($data, $dias)
{
	return date("d/m/Y", mktime(0, 0, 0, Extrair_Mes($data), Extrair_Dia($data) - $dias, Extrair_Ano($data)));
}


/**
 * Adiciona meses a uma determinada data
 * @param string $data Data no formato dd/mm/AAAA
 * @param integer $meses Meses para serem adicionados
 * @return string Data somada aos dias passados como par�metros
 */
function Adiciona_Meses_A_Data($data, $meses)
{
	return date("d/m/Y", mktime(0, 0, 0, Extrair_Mes($data)  + $meses, Extrair_Dia($data), Extrair_Ano($data)));
}


/**
 * Compara datas d/m/Y
 * @param string $data1 primeira data a ser comparada
 * @param string $data2 segunda data a ser comparada
 * @return @interger 0 para datas iguais, -1 para primiera data maior que segunda
 * 1 para segunda data maior que primeira
 */
function Compara_Datas($data1, $data2)
{
	$data1 = $this::Extrair_Ano($data1) . $this::Extrair_Mes($data1) . $this::Extrair_Dia($data1);
	$data2 = $this::Extrair_Ano($data2) . $this::Extrair_Mes($data2) . $this::Extrair_Dia($data2);

	if ($data1 == $data2)
		return 0;
	if ($data1 > $data2)
		return -1;
	if ($data1 < $data2)
		return 1;
}

/**
 * Retorna a data atual no formato dd/mm/AAAA
 * @return string Data atual no formato dd/mm/AAAA
 */
function Data_Atual()
{
	return date("d/m/Y");
}

/**
 * Retorna a data no formato para exibi��o (dd/mm/AAAA)
 * @param string $data Data no formato AAAA-mm-dd
 * @return string Data no formato dd/mm/AAAA
 */
function Data_FireBird_Para_Exibicao($data)
{

	if (strlen(trim(str_replace('/', '', $data))) == 0)
		return '';

	$data = Fragmenta_Data('-', $data);
	return "{$data[2]}/{$data[1]}/{$data[0]}";
}

/**
 * Retorna a data no formato aceito pelo banco de dados FireBird
 * @param string $data Data no formato dd/mm/AAAA
 * @return string Data formatada no formato Firebird (AAAA-mm-dd)
 */
function Data_No_Formato_FireBird($data)
{
	if (strlen(trim(str_replace('/', '', $data))) == 0)
		return '';

	return Extrair_Ano($data) . '-' . Extrair_Mes($data) . '-' . Extrair_Dia($data);
}

/**
 * Retorna a data no formato aceito pelo banco de dados MySQL
 * @param string $data Data no formato dd/mm/AAAA
 * @return string Data no formato AAAA/mm/dd
 */
function Data_No_Formato_MySQL($data)
{
	if (strlen(trim(str_replace('/', '', $data))) == 0)
		return '';

	return Extrair_Ano($data) . '/' . Extrair_Mes($data) . '/' . Extrair_Dia($data);
}

/**
 * Retorna a data por extenso
 * @param string $data Data no formato dd/mm/AAAA
 * @example Sexta-feira, 19 de Agosto de 2011
 * @return string Data por extenso
 */
function Data_Por_Extenso($data)
{
	$dia = Extrair_Dia($data);
	$mes = Extrair_Mes($data);
	$ano = Extrair_Ano($data);
	$dia_semana = Dia_Da_Semana(date("w", mktime(0, 0, 0, $mes, $dia, $ano)));
	$mes = Nome_Do_Mes($mes);
	return "{$dia_semana}, {$dia} de {$mes} de {$ano}";
}

/**
 * Retorna a data no formato para exibi��o (dd/mm/AAAA)
 * @param string $data Data no formato AAAA/mm/dd
 * @return string Data no formato dd/mm/AAAA
 */
function Data_MySQL_Para_Exibicao($data)
{
	if (strlen(trim(str_replace('/', '', $data))) == 0)
		return '';

	$data = Fragmenta_Data('/', $data);
	return "{$data[2]}/{$data[1]}/{$data[0]}";
}

/**
 * Retorna o dia da semana
 * @param integer $dia Dia da semana (0: Domingo | 6: S�bado)
 * @return string Dia da semana por extenso
 */
function Dia_Da_Semana($dia)
{
	switch ($dia) {
		case 0:
			return 'Domingo';
		case 1:
			return 'Segunda-feira';
		case 2:
			return 'Terça-feira';
		case 3:
			return 'Quarta-feira';
		case 4:
			return 'Quinta-feira';
		case 5:
			return 'Sexta-feira';
		case 6:
			return 'Sábado';
	}
}

/**
 * Retorna a diferen�a (em dias) entre a primeira e segunda data
 * @param string $primeira_data Primeira data no formato dd/mm/YYYY
 * @param string $segunda_data Segunda data no formato dd/mm/YYYY
 * @return integer N�mero que representa a quantidades de dias entre uma data e outra
 */
function Diferenca_Entre_Datas($primeira_data, $segunda_data)
{
	$primeira_data = mktime(0, 0, 0, $this::Extrair_Mes($primeira_data), $this::Extrair_Dia($primeira_data), $this::Extrair_Ano($primeira_data));
	$segunda_data  = mktime(0, 0, 0, $this::Extrair_Mes($segunda_data), $this::Extrair_Dia($segunda_data), $this::Extrair_Ano($segunda_data));

	return floor(($primeira_data - $segunda_data) / 86400);
}

/**
 * Retorna o ano
 * @param string $data Data no formato dd/mm/AAAA
 * @return string Ano da data
 */
function Extrair_Ano($data)
{
	$data = Fragmenta_Data('/', $data);
	return (string) $data[2];
}

/**
 * Retorna o dia
 * @param string $data Data no formato dd/mm/AAAA
 * @return string Dia da data
 */
function Extrair_Dia($data)
{
	$data = Fragmenta_Data('/', $data);
	return (string) $data[0];
}

/**
 * Retorna o m�s
 * @param string $data Data no formato dd/mm/AAAA
 * @return string M�s da data
 */
function Extrair_Mes($data)
{
	$data = Fragmenta_Data('/', $data);
	return (string) $data[1];
}

/**
 * Divide a data de acordo com o par�metro passado
 * @param string $parametro_de_divisao Passado que define o modo de divis�o
 * @param string $data Data que ser� dividida
 * @return array Array contendo a data dividida
 */
function Fragmenta_Data($parametro_de_divisao, $data)
{
	return explode($parametro_de_divisao, $data);
}

/**
 * Retorna array com os anos entre o ano fornecido ao ano atual.
 * @author Bruno C�sar Bulnes
 * @param Integer $ano_inicial recebe o ano inicial para array
 * @return array Anos a partir do ano inicial at� o ano atual
 */
function Intervalo_De_Anos($ano_inicial)
{
	$anos = array();
	$ano_atual = Extrair_Ano(Data_Atual());
	for ($i = $ano_inicial; $i <= $ano_atual; $i++)
		$anos[$i] = $i;
	return $anos;
}

/**
 * Retorna array com os anos entre o ano incial e final fornecidos.
 * @author Fernando Saga
 * @param Integer $ano_inicial recebe o ano inicial para array
 * @param Integer $ano_final recebe o ano final para array
 * @return array Anos a partir do ano inicial at� o ano final
 */
function Intervalo_De_Anos_Inicial_E_Final($ano_inicial, $ano_final)
{
	$anos = array();
	for ($i = $ano_inicial; $i <= $ano_final; $i++)
		$anos[$i] = $i;
	return $anos;
}

/**
 * Array com os meses do ano
 * @author Bruno C�sar Bulnes
 * @return array Array com os todos meses do ano
 */
function Meses_Do_Ano()
{
	$meses = array();
	for ($i = 1; $i < 13; $i++) {
		$mes = Preenche_Texto($i, 2, '0', STR_PAD_LEFT);
		$meses[$mes] = Nome_Do_Mes($mes);
	}
	return $meses;
}

/**
 * Retorna o nome do m�s por extenso
 * @param string $mes N�mero do m�s
 * @return string M�s por extenso
 */
function Nome_Do_Mes($mes)
{
	switch ($mes) {
		case '01':
			return 'Janeiro';
		case '02':
			return 'Fevereiro';
		case '03':
			return 'Mar�o';
		case '04':
			return 'Abril';
		case '05':
			return 'Maio';
		case '06':
			return 'Junho';
		case '07':
			return 'Julho';
		case '08':
			return 'Agosto';
		case '09':
			return 'Setembro';
		case '10':
			return 'Outubro';
		case '11':
			return 'Novembro';
		case '12':
			return 'Dezembro';
	}
}

/**
 * Remove dias a uma determinada data
 * @param string $data Data no formato dd/mm/AAAA
 * @param integer $dias Dias para serem subtra�dos
 * @return string Data subtra�da aos dias passados como par�metros
 */
function Remove_Dias_Da_Data($data, $dias)
{
	return date("d/m/Y", mktime(0, 0, 0, Extrair_Mes($data), Extrair_Dia($data) - $dias, Extrair_Ano($data)));
}

/**
 * Retorna o �ltimo dia do m�s
 * @param string $data Data no formato dd/mm/AAAA
 * @return int �ltimo dia do m�s
 */
function Ultimo_Dia_Do_Mes($data)
{
	$dias_fevereiro = 28;
	if (date("L", mktime(0, 0, 0, 1, 1, Extrair_Ano($data))) != 0) # se ano for bisexto
		$dias_fevereiro = 29;

	switch (Extrair_Mes($data)) {
		case '01':
			return 31;
		case '02':
			return $dias_fevereiro;
		case '03':
			return 31;
		case '04':
			return 30;
		case '05':
			return 31;
		case '06':
			return 30;
		case '07':
			return 31;
		case '08':
			return 31;
		case '09':
			return 30;
		case '10':
			return 31;
		case '11':
			return 30;
		case '12':
			return 31;
	}
}

/* M�todo que recebe um ano e seu antecessor e sucessor.
		 * $ano Integer Parametro que recebe um ano.
		 */
function Recebe_Anos($ano)
{
	return array(
		$ano - 1 => $ano - 1,
		$ano => $ano,
		$ano + 1 => $ano + 1
	);
}

/**
 * Retorna o dia da semana ao informar uma data
 * @param string $data Data no formato dd/mm/AAAA
 * @param integer $tipo, 0 -> n�mero, 1 -> texto
 * @return
 *    se $tipo = 0 -> integer n�mero do dia da semana
 *    se $tipo = 1 -> string o dia da semana por extenso
 */
function Dia_Da_Semana_Passando_a_Data($data, $tipo)
{
	$dia =  substr($data, 0, 2);
	$mes =  substr($data, 3, 2);
	$ano =  substr($data, 6, 9);

	$dia_da_semana = date("w", mktime(0, 0, 0, $mes, $dia, $ano));

	if ($tipo == 0)
		return $dia_da_semana;
	elseif ($tipo == 1)
		return Dia_Da_Semana($dia_da_semana);
}

/**
 * Retorna o numero de dias entre 2 datas, contando somente de segunda a sabado
 * @param string $data1 Data inicial no formato dd/mm/AAAA
 * @param string $data2 Data inicial no formato dd/mm/AAAA
 * @param integer $tipo, 0 -> n�mero, 1 -> texto
 * @return uteis
 */
function Dias_Entre_Datas_Seg_a_Sab($data1, $data2)
{
	$segundos_datainicial = strtotime(str_replace("/", "-", $data1));
	$segundos_datafinal   = strtotime(str_replace("/", "-", $data2));
	$dias                 = abs(floor(floor(($segundos_datafinal - $segundos_datainicial) / 3600) / 24));
	$uteis                = 0;

	for ($i = 1; $i <= $dias; $i++) {
		$diai = $segundos_datainicial + ($i * 3600 * 24);
		$w = date('w', $diai) . "<br />";

		if ($w != 0)
			$uteis++;
	}

	return $uteis;
}

/**
 * Retorna a diferenca entre datas contabilizando tambem as horas
 * @param string $inicio Data inicial no formato dd/mm/AAAA hh:mm:yy
 * @param string $fim Data inicial no formato dd/mm/AAAA h:mm:yy
 * @return objeto contendo a diferenca.
 */
function Diferenca_Entre_Datas_Com_Horas($inicio, $fim)
{
	date_default_timezone_set('America/Sao_Paulo');
	// Converte as duas datas para um objeto DateTime do PHP
	// PARA O PHP 5.3 OU SUPERIOR
	$inicio = DateTime::createFromFormat('d/m/Y H:i:s', $inicio);
	// PARA O PHP 5.2
	// $inicio = date_create_from_format('d/m/Y H:i:s', $inicio);

	$fim = DateTime::createFromFormat('d/m/Y H:i:s', $fim);
	// $fim = date_create_from_format('d/m/Y H:i:s', $fim);

	$intervalo = $inicio->diff($fim);

	return $intervalo;
}

/**
 * Retorna o n�mero do mes
 * @param string $mes m�s
 * @return string M�s num�rico
 */
function Numero_mes($mes)
{
	switch ($mes) {
		case 'Janeiro':
			return '01';
		case 'Fevereiro':
			return '02';
		case 'Mar�o':
			return '03';
		case 'Abril':
			return '04';
		case 'Maio':
			return '05';
		case 'Junho':
			return '06';
		case 'Julho':
			return '07';
		case 'Agosto':
			return '08';
		case 'Setembro':
			return '09';
		case 'Outubro':
			return '10';
		case 'Novembro':
			return '11';
		case 'Dezembro':
			return '12';
	}
}

/**
 * Retorna o qual semana do ano o dia faz parte
 * @param date $data data no formato SQL (YYYY-mm-dd)
 * @return int semana
 */
function Semana_Do_Mes($data)
{
	$data  = explode("-", $data);
	$date  = mktime(0, 0, 0, $data[1], $data[2], $data[0]);
	return (int)date('W', $date);
}

/**
 * Retorna o dia da semana de uma data
 * @param date $data data no formato YYYY-mm-dd a ser analisada
 * @return String dia da semana
 */
function Dia_Na_Semana($data)
{
	$ano =  substr($data, 0, 4);
	$mes =  substr($data, 5, -3);
	$dia =  substr($data, 8, 9);

	return $this::Dia_Da_Semana(date("w", mktime(0, 0, 0, $mes, $dia, $ano)));
}

/* Array com os meses do ano
		* @author Ackeley Lennon
		* @return array Array com os todos meses do ano abreviado Ex(Jan, Fev, etc..)
		*/
function Meses_Do_Ano_abreviado()
{
	$meses = array();
	for ($i = 1; $i < 13; $i++) {
		$mes = Preenche_Texto($i, 2, '0', STR_PAD_LEFT);
		$meses[$mes] = Nome_Do_Mes_abreviado($mes);
	}
	return $meses;
}

/**
 * Retorna o nome do m�s por abreviado
 * @author Ackeley Lennon
 * @param string $mes N�mero do m�s
 * @return string M�s por extenso
 */
function Nome_Do_Mes_abreviado($mes)
{
	switch ($mes) {
		case '01':
			return 'Jan';
		case '02':
			return 'Fev';
		case '03':
			return 'Mar';
		case '04':
			return 'Abr';
		case '05':
			return 'Mai';
		case '06':
			return 'Jun';
		case '07':
			return 'Jul';
		case '08':
			return 'Ago';
		case '09':
			return 'Set';
		case '10':
			return 'Out';
		case '11':
			return 'Nov';
		case '12':
			return 'Dez';
	}
}

/**
 * Retorna a data no padrao brasileiro, quando esta no padrao americano com a hora EX: XXXX-XX-XX 00:00:00.
 * @author Ackeley Lennon
 * @param date $data variavel contendo a data EX: XXXX-XX-XX 00:00:00
 * @return string data formato brasileiro.
 */

function Data_Exibicao_SQL_Sem_Hora($data)
{
	$dt = substr($data, 0, -9);
	$data = explode("-", $dt);
	$data = $data['2'] . "/" . $data['1'] . "/" . $data['0'];

	return $data;
}

/**
 * Retorna a data no padrao brasileiro, quando esta no padrao americano com a hora EX: XXXX-XX-XX 00:00:00.
 * @author Wellington Almeida
 * @param date $data variavel contendo a data EX: XXXX-XX-XX 00:00:00
 * @return string data formato brasileiro.
 */

function Data_Exibicao_SQL_Sem_Horario($data)
{
	$dt = substr($data, 0, -13);
	$data = explode("-", $dt);
	$data = $data['2'] . "/" . $data['1'] . "/" . $data['0'];

	return $data;
}

/**
 * Retorna a data hora no padrao brasileiro, quando esta no padrao americano com a hora EX: XXXX-XX-XX 00:00:00.
 * @param date $data variavel contendo a data EX: XXXX-XX-XX 00:00:00
 * @return string data formato brasileiro.
 */

function DataHora_Exibicao_SQLServer($data)
{
	$dados = explode(" ", $data);
	$dt = $dados[0];
	$hr = $dados[1];

	$data = explode("-", $dt);
	$data = $data['2'] . "/" . $data['1'] . "/" . $data['0'];

	$hora = explode(":", $hr);
	$hora = $hora[0] . ':' . $hora[1] . ':' . $hora[2];

	return $data . ' ' . $hora;
}

/**
 * Retorna a hora no padrao brasileiro sem data quando o campo é datetme.
 * @author Wellington Almeida
 * @param datetime $data variavel contendo a data EX: XXXX-XX-XX 00:00:00
 * @return string data formato brasileiro.
 */

function Hora_Exibicao_SQL_Sem_Data($data)
{

	$date = strtotime($data);
	return date('H:i', $date);
}

/**
 * Retorna o dia da semana, mudando a posi��o de 0 => Domingo para 7 => domingo.
 * @author Ackeley Lennon
 * @param date $data variavel
 * @return int o codigo do cia da semana.
 */
function Dia_Da_Semana_Inicio_Segunda($data)
{

	$dia_da_semana = Dia_Da_Semana_Passando_a_Data($data, 0);

	if ($dia_da_semana == '0') {
		$dia_da_semana = '7';
	}

	return $dia_da_semana;
}
