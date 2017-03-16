# qiniu-files
七牛文件浏览器
在项目根目录添加配置文件`config.yaml`,配置示例查看`config.yaml.example`
```yaml
qiniu:
  accessKey: 'your access key'
  secretKey: 'your secret key'
  bucket: 'bucket name'
  domain: 'your domain'
user:
  username: your_user
  password: password_hash
```
* 密码使用password_hash('password', PASSWORD_DEFAULT);生成
* 也可以执行`pass.php`生成



