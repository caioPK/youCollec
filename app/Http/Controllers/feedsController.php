<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
class feedsController extends Controller
{
    function xmlToArray($xml, $options = array()) {
        $defaults = array(
            'namespaceSeparator' => ':', // você pode querer que isso seja algo diferente de um cólon
            'attributePrefix' => '@',    // para distinguir entre os nós e os atributos com o mesmo nome
            'alwaysArray' => array(),    // array de tags que devem sempre ser array
            'autoArray' => true,         // só criar arrays para as tags que aparecem mais de uma vez
            'textContent' => '$',        // chave utilizada para o conteúdo do texto de elementos
            'autoText' => true,          // pular chave "textContent" se o nó não tem atributos ou nós filho
            'keySearch' => false,        // pesquisa opcional e substituir na tag e nomes de atributos
            'keyReplace' => false        // substituir valores por valores acima de busca
        );
        $options = array_merge($defaults, $options);
        $namespaces = $xml->getDocNamespaces();
        $namespaces[''] = null; // adiciona namespace base(vazio)
        // Obtém os atributos de todos os namespaces
        $attributesArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
                // Substituir caracteres no nome do atributo
                if ($options['keySearch']) $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
                $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
                $attributesArray[$attributeKey] = (string)$attribute;
            }
        }
        // Obtém nós filhos de todos os namespaces
        $tagsArray = array();
        foreach ($namespaces as $prefix => $namespace) {
            foreach ($xml->children($namespace) as $childXml) {
                // Recursividade em nós filho
                $childArray = $this->xmlToArray($childXml, $options);
                list($childTagName, $childProperties) = each($childArray);
                // Substituir caracteres no nome da tag
                if ($options['keySearch']) $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
                // Adiciona um prefixo namespace, se houver
                if ($prefix) $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
                if (!isset($tagsArray[$childTagName])) {
                    // Só entra com esta chave
                    // Testa se as tags deste tipo deve ser sempre matrizes, não importa a contagem de elementos
                    $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                            ? array($childProperties) : $childProperties;
                } elseif (
                    is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                    === range(0, count($tagsArray[$childTagName]) - 1)
                ) {
                    $tagsArray[$childTagName][] = $childProperties;
                } else {
                    $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
                }
            }
        }
        // Obtém o texto do nó
        $textContentArray = array();
        $plainText = trim((string)$xml);
        if ($plainText !== '') $textContentArray[$options['textContent']] = $plainText;
        $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;
        // Retorna o nó como array
        return array(
            $xml->getName() => $propertiesArray
        );
    }
    /**
     * Resolve o envio do arquivo.
     *
     * @param Request $request A instância do request.
     * @return Response A instância da response.
     */
    public function upload(Request $request)
    {
        $file = Input::file('file');
        $xml = simplexml_load_file($file);
        return view('gerenciar',['xml'=>$xml]);
    }
    public function gerenciarXML()
    {
        return view('comecando');
    }
    public function criando(Request $request)
    {
        $file = $request->input('hlista');
        $nome = $request->input('name');
        $lista = explode('@',$file );

        return view('criando',['nome'=>$nome, 'lista' =>$file]);
    }
}