<?php

/**
 * Classe central que manipula texto
 * @author Bruno C�sar Bulnes , Ackeley Lennon, Fernando Saga.
 * @see Sistema Suprimentos, Sistema BI.
 */

    function Nome_No_Formato_Padrao($nome)
    {
        $delimiters = array(" ", "-", ".", "'", "O'", "Mc");
        $exceptions = array("e", "da", "das", "do", "dos", "de", "I", "II", "III", "IV", "V", "VI");

        $string = mb_convert_case($nome, MB_CASE_TITLE, "UTF-8");

        foreach ($delimiters as $dlnr => $delimiter)
        {
            $words = explode($delimiter, $string);
            $newwords = array();

            foreach ($words as $wordnr => $word)
            {
                if (in_array(mb_strtoupper($word, "UTF-8"), $exceptions))
                {
                    $word = mb_strtoupper($word, "UTF-8");
                }
                elseif (in_array(mb_strtolower($word, "UTF-8"), $exceptions))
                {
                    $word = mb_strtolower($word, "UTF-8");
                }
                elseif (!in_array($word, $exceptions))
                {
                    $word = ucfirst($word);
                }
                array_push($newwords, $word);
            }
            $string = join($delimiter, $newwords);
       }

       return $string;
    }

    /**
     * UCFIRST humano
     * @param string Nome (charset ISO-8859-1)
     * @return string Nome formatado (charset ISO-8859-1)
     */
     function Nome_No_Formato_Padrao_ISO($nome)
    {
        return utf8_decode( Nome_No_Formato_Padrao(utf8_encode($nome)) );
    }

    /**
     * Tranforma caracteres especiais min�sculos em mai�sculos
     * @param string $texto Texto com acentos
     * @return string Texto mai�sculo com acentos
     */
     function Converte_Caracteres_Especiais_Para_Maiusculo($texto)
    {
        return strtr($texto, '�������������', '�������������');
    }

    /**
     * Tranforma caracteres especiais mai�sculos em min�sculos
     * @param string $texto Texto com acentos
     * @return string Texto mai�sculo com acentos
     */

     function Converte_Caracteres_Especiais_Para_Min�sculos($texto)
    {
        return strtr($texto, '�������������', '�������������');
    }


    /**
     * Preenche um texto de acordo com os par�metros passados
     * @param string $texto Texto para ser preenchido
     * @param integer $tamanho Tamanho do novo texto
     * @param string $preenchimento Caracter que deve ser colocado no texto
     * @param mixed $direcao Dire��o do preenchimento. Poss�veis valores; STR_PAD_LEFT, STR_PAD_BOTH ou STR_PAD_RIGHT
     * @return string Texto preenchido
     */
     function Preenche_Texto($texto, $tamanho, $preenchimento = ' ', $direcao = STR_PAD_RIGHT)
    {
        $opcao = array(
          'left' => STR_PAD_LEFT,
          STR_PAD_LEFT => STR_PAD_LEFT,
          'right' => STR_PAD_RIGHT,
          STR_PAD_RIGHT => STR_PAD_RIGHT,
          'both' => STR_PAD_BOTH,
          STR_PAD_BOTH => STR_PAD_BOTH
        );
        return str_pad($texto, $tamanho, $preenchimento, $opcao[$direcao]);
    }

    /**
     * Deixa somente a primeira letra do texto em mai�sculo
     * @param string $texto Texto a ser convertido
     * @return string Texto convertido
     */
     function Primeira_Letra_Em_Maiusculo($texto)
    {
        return ucfirst(Texto_Minusculo($texto));
    }

    /**
     * Deixa somente a primeira letra de cada palavra do texto em mai�sculo
     * @param string $texto Texto a ser convertido
     * @return string Texto convertido
     */
     function Primeira_Letra_De_Cada_Palavra_Em_Maiusculo($texto)
    {
        return ucwords( strtolower( $texto ) );
    }

    /**
     * Remove acentos do texto passado como par�metro
     * @param string $texto Texto com acentos
     * @return string Texto sem acentos
     */
     function Remove_Caracteres_Especiais($texto)
    {
        return strtr($texto, '��������������������������', 'AAAAEEIOOOUUCaaaaeeiooouuc');
    }

	 /**
     * Retorna texto sem espa�os ideal para nomes de arquivos
     * @param string $texto Texto a ser tirado os espa�os
     * @return string Texto contendo o texto sem espa�os
     */
	 function Remove_Espaco_Entre_As_Palavras($texto)
	{
    	return str_replace(' ', '_', $texto);
	}

    /**
     * Retorna peda�o do texto
     * @param string $texto Texto a ser "cortado"
     * @param integer $inicio In�cio do corte
     * @param integer $comprimento Comprimento do corte
     * @return string Texto contendo somente o que foi cortado
     */
     function Retorna_Pedaco_Do_Texto($texto, $inicio, $comprimento = NULL)
    {
        return substr($texto, $inicio, $comprimento);
    }

    /**
     * Converte o texto para mai�sculo
     * @param string $texto Texto para ser convertido
     * @return string Texto em mai�sculo
     */
     function Texto_Maiusculo($texto)
    {
        return strtoupper($texto);
    }

    /**
     * Converte o texto para mai�sculo e com acentos
     * @param string $texto Texto para ser convertido
     * @return string Texto em mai�sculo e sem acentos
     */
     function Texto_Maiusculo_Com_Acento($texto)
    {
        return Texto_Maiusculo(Converte_Caracteres_Especiais_Para_Maiusculo($texto));
    }

    /**
     * Converte o texto para mai�sculo e sem acentos
     * @param string $texto Texto para ser convertido
     * @return string Texto em mai�sculo e sem acentos
     */
     function Texto_Maiusculo_Sem_Acento($texto)
    {
        return Texto_Maiusculo(Remove_Caracteres_Especiais($texto));
    }

    /**
     * Converte o texto para min�sculo
     * @param string $texto Texto a ser convertido
     * @return string Texto convertido
     */
     function Texto_Minusculo($texto)
    {
        return strtolower($texto);
    }

	/**
	 * Substitui os caracteres procurados por outros caracteres
	 * @param string $procura_por caracteres a ser procurado para a substitui��o
	 * @param string $substitui_por Novos Caracteres utilizado no Texto
     * @param string $texto Texto a ser alterado
     * @return string Texto contendo caracteres procurados que foram substituidos pelos novos caracteres
	**/
	 function Substitui_Caracteres($procura_por, $substitui_por, $texto)
	{
		return str_replace($procura_por, $substitui_por, $texto);
	}

    /**
     * Remove caracteres passados por par�metro
     * @param string $texto Texto
	 * @param array $caracteres Array com os caracteres a ser removidos
     * @return string Texto sem os caracteres passados por par�metro
     */
	 function Remover_Caracteres($texto, $caracteres = array())
	{
		foreach ($caracteres as $caracter)
			$texto = str_replace($caracter, "", $texto);

		return $texto;
	}
	
	/**
     * cria a marcara para qualquer valor
     * @param string $val Valor a ser aplicado a mascara
	 * @param array $mask Mascara que deve ser formatada. Exemplo
	 * mascara para CPF deve ser passado a seguinte string "###.###.###-##"
	 * mascara para CEP deve ser passado a seguinte string "#####-###" ... pode formatar qualquer string!
     * @return string $maskared valor com a mascara
     */
		 function mask($val, $mask){
			 $maskared = '';
			 $k = 0;
			 
			 for($i = 0; $i<=strlen($mask)-1; $i++){
				 if($mask[$i] == '#'){
					 if(isset($val[$k]))
					 $maskared .= $val[$k++];
				 }else{
					 if(isset($mask[$i]))
						$maskared .= $mask[$i];
				}
			 }
		 return $maskared;
		}



    /**
     * Adiciona aspas simples em uma string
     * @param  $texto a ser colocado as aspas
     * @return string texto
     *   
     */
     function adicionaAspasSimples($texto)
    {
        if(is_array($texto)){
            $texto = implode(',', $texto);
        }
        else{
            $texto = "'".$texto."'";
        }
        return $texto;
    }

    /**
     * Limita o tamanho do texto quebrando ou n�o quebrando a �ltima palavra do texto.
     * @param  string $texto Texto
     * @param  integer $limite Quantidade limite
     * @param  boolean $quebra true Quebra a �ltima palavra da frase | false: N�o quebra
     * @return string Novo texto
     *   
     */
     function Limita_Texto($texto, $limite, $quebra = true) {
        $tamanho = strlen($texto);

        // Verifica se o tamanho do texto � menor ou igual ao limite
        if ($tamanho <= $limite) {
            $novo_texto = $texto;
        // Se o tamanho do texto for maior que o limite
        } 
        else {
            // Verifica a op��o de quebrar o texto
            if ($quebra == true) {
                $novo_texto = trim(substr($texto, 0, $limite)).' ...';
            // Se n�o, corta $texto na �ltima palavra antes do limite
            } else {
                // Localiza o �tlimo espa�o antes de $limite
                $ultimo_espaco = strrpos(substr($texto, 0, $limite), ' ');
                // Corta o $texto at� a posi��o localizada
                $novo_texto = trim(substr($texto, 0, $ultimo_espaco)).' ...';
            }
        }

        // Retorna o valor formatado
        return $novo_texto;
    }    


    /**
     * Transforma em CPF ou CNPJ.
     * @param  string $texto Texto
     * @return string Novo CNPJ OU CPF formatado
     *   
     */
    function formatCnpjCpf($value)
    {
    $cnpj_cpf = preg_replace("/\D/", '', $value);
    
    if (strlen($cnpj_cpf) === 11) {
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
    } 
    
    return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
    }

    /**
     * String para Somente Numeros.
     * @param  string $string string
     * @return string Texto somente com numeros
     *   
     */
    function somenteNumeros(string $string)
	{
		  return preg_replace("/[^0-9]/", "", $string); 
    }

    function moeda($get_valor) {

        $source = array('.', ',');
        $replace = array('', '.');
        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        return $valor; //retorna o valor formatado para gravar no banco
    }

