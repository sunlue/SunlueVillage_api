#### 序言
Sunlue CMS是一款基于ThinkPHP6.0+MySQL8.0开发的多语言内容管理框架，系统提出灵活的应用机制。每个应用都能独立的完成自己的任务，也可通过系统调用其他应用进行协同工作。
#### 版权声明
未经版权所有者(sunlue.com)明确授权，禁止发行本文档及其被实质上修改的版本。未经版权所有者(sunlie.com)事先授权，禁止将此作品及其衍生作品以标准（纸质）书籍形式发行。如果有兴趣再发行或再版本手册的全部或部分内容，不论修改过与否，或者有任何问题，请联系版权所有者。
#### 快速入门
#### 数据标签
* 站点信息标签 
~~~
{Site:info}
~~~
| 参数| 参数可选值     | 必填项  | 说明   |
|-----|----------------|---------|--------|
| key|title,seoTitle,seo_title|Yes|站点SEO标题|
| key|keywords,seoKeywords,seo_keywords|Yes|站点SEO关键词|
| key|description,seoDescription,seo_description|Yes|站点SEO描述|
| line| |No|数据连接线样式|
| suffix| |No|数据前缀|
| prefix| |No|数据后缀|

模板文件写法，以下示例则输出为：sunlue_{title}_cms
~~~
{Site:info key="title" line="_" suffix="sunlue" prefix="cms"}
~~~

* 幻灯片标签 
~~~
{Slide:get}{/Slide:get} 
~~~
| 参数| 参数类型     | 必填项   |默认值   | 说明   |
|-----|----------------|----------|--------|--------|
| nav | String | Yes |  | 要输出对应栏目的幻灯片栏目参数,支持变量 |
| row | String | No | row | 变量名称 |
| item | String | No | item | 循环变量 |
| filed| String | No | Yes | 输出字段,参考mysql查询字段写法 |
| where| String | No | Yes | 查询条件,参考mysql查询条件写法 |
| empty| String | No | Yes | 数据为空时输出提示 |

~~~
{Slide:get nav="$nav" row="row" item="item" field="uniqid,name,image" where="$where" empty="暂时没有数据"}
    <img src="{$item.image}" alt="{$item.name}" />
{/Slide:get}
~~~
empty属性不支持直接传入html语法，但可以支持变量输出，例如：
~~~
$this->assign('empty','<span class="empty">没有数据</span>');
$this->assign('list',$list);
~~~
然后在模板中使用：
~~~
{Slide:get empty="$empty" }
    {$vo.id}|{$vo.name}
{/Slide:get}
~~~
