* 如果出现'不能在此路径中使用此配置节。"解决方法：
* 出现这个错误是因为 IIS 7 采用了更安全的 web.config 管理机制，默认情况下会锁住配置项不允许更改。要取消锁定可以以管理员身份运行命令行 %windir%\system32\inetsrv\appcmd unlock config -section:system.webServer/handlers 。其中的 handlers 是错误信息中红字显示的节点名称。如果modules也被锁定，可以运行%windir%\system32\inetsrv\appcmd unlock config -section:system.webServer/modules
* 注意：要以管理员身份运行才可以，默认不是管理员身份，方法，在开始菜单中的搜索程序与文件输入CMD，就会在上方出现一个CMD.EXE，在这个CMD.EXE文件上点击键，选择“以管理员身份运行”，打开命令行窗口，输入以上命令即可。
