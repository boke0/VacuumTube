<?php

namespace Boke0\Mechanism\Plugins\VacuumTube\Mdl;
use \Boke0\Mechanism\MarkdownParser;

class Article{
    const ROOTPATH="/../../../contents";
    public function __construct(){
        $this->parser=new \Mni\FrontYAML\Parser(
            NULL,
            new MarkdownParser()
        );
    }
    public function getDirList($path){
        if(substr($path,-1,1)!="/") $path="$path/";
        if(substr($path,0,1)!="/") $path="/$path";
        $list=[
            "sections"=>array(),
            "pages"=>array(),
            "index"=>[
                "slug"=>"__index",
                "path"=>$path."__index.md"
            ],
            "menu"=>[
                "slug"=>"__menu",
                "path"=>$path."__menu.md"
            ]
        ];
        $dir=array_slice(scandir(__DIR__.self::ROOTPATH.$path),2);
        foreach($dir as $n){
            if(substr($n,0,1)=="."||substr($n,-4)=="json"||$n=="__menu.md") continue;
            if(is_dir(__DIR__.self::ROOTPATH.$path.$n)){
                if(file_exists(__DIR__.self::ROOTPATH.$path.$n."/__index.md")){
                    $text=$this->parser->parse(
                        file_get_contents(__DIR__.self::ROOTPATH.$path.$n."/__index.md")
                    );
                    $title=$text->getYAML()["title"];
                }else{
                    $title=$n;
                }
                array_push($list["sections"],[
                    "title"=>$title,
                    "slug"=>$n,
                    "path"=>urlencode($path.$n)
                ]);
            }else if($n=="__index.md"){
                $text=$this->parser->parse(
                    file_get_contents(__DIR__.self::ROOTPATH.$path."__index.md")
                );
                $title=$text->getYAML()["title"];
                $list["index"]["title"]=$title;
            }else{
                $text=$this->parser->parse(
                    file_get_contents(__DIR__.self::ROOTPATH.$path.$n)
                );
                if($text!=""){
                    $title=$text->getYAML()["title"];
                }else{
                    $title=substr($n,0,-3);
                }
                array_push($list["pages"],[
                    "title"=>$title,
                    "slug"=>substr($n,0,-3),
                    "path"=>$path.$n
                ]);
            }
        }
        $list["path"]=$path;
        return $list;
    }
    public function getArticle($path){
        return file_get_contents(__DIR__.self::ROOTPATH.$path);
    }
    public function postArticle($path,$markdown){
        if(file_exists(__DIR__.self::ROOTPATH.$path)) unlink(__DIR__.self::ROOTPATH.$path);
        $fp=fopen(__DIR__.self::ROOTPATH.$path,"w");
        fwrite($fp,$markdown);
        fclose($fp);
    }
    public function createSection($path){
        mkdir(__DIR__.self::ROOTPATH.$path);
    }
}
