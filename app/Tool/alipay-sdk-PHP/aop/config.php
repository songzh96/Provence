<?php
$config = array (	
		//应用ID,您的APPID。
		'app_id' => "2016080200150514",

		//商户私钥，您的原始格式RSA私钥
		'merchant_private_key' => "MIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCnmYVmGMemY6knYAoDRiJtlTnOi5zTiv93ARbVhshDyHNaHyDHM+IHIhPsHvFVCLwUTMLIgOKgdvEXmsncMutvX+W4Xixxq3g3IDPyftPlEJ7uf/nFV6MT5T35K7YDupUyggQRtRFA8mYwn0yRQMEkzTFkyfyK/u48/9N+eZMSyKYK+hVPNl/YO1xE3Haa6JkYh1YIwzI1TDVVLepXlGk4eCqwLXf9/ZnfBdd0yeTwzVPkKmp0+gORMWfxiEusRC2tjCPhMmGKzoOkMcHAW8jCi1M6CWoYGwh8HQ6TsgSaW9SPLujnjYgTi96mAfSnsla/WOBNW1AmANS2WTD+ch6HAgMBAAECggEAEcanrm98ZXp2i3WVOkmrByJnsi9+n7VDaTTVXipgfUf6bBmXGWm4VHdZ05ZolFNL139YvXlmEAztf0pslI1WCUcLj2V1o0zDgF1LBTJMeSQtJzCtpi+oXUjYLOBk+rpEbsn5coNY5CGRkyCiN1m94pBc58rAnWFylUew/94XKkuvooi44sL99EpTPe9Zcs2r8vTLY7dTKbAOrv6h3fRJW3s2CLjelPadPnO0DnrdNDHLLTz6awnWyWN5zaaOod/anMIuNQss1vZpwgNQmipNAnhU9mVVN0ys3yW+6T6M10Cw9KyAZEGi0rejCwh1K2QQcaT+jZrktQT1vfFHUnB4qQKBgQDkZnQGrgTREsWNvTplILOnsV1UtTcPfuM5Rd4OIhrnrikvXDpaG+oigRwCYzuN6p5n5EYV3bhCgCLMP0BR4G79noJy0xGKbEPnMRhLtOWNqDWv3xigirwoNZGvyVqAWFTDwgO8DYE27jrnA5rg78+IvpaSYxZn2mclQDoSWi0nowKBgQC72jUgu1jKklS26aaVipdlig0CAd7lNQ7GsT0LqQCVjA4uHi67aGv/Aah6f62oC9rmlaJFfYD1poAb24RBOqJPAnMr+6A8pwVyaWkjDQMiEUMPbBeVMdEwDeDZSOgtwNkO6OJchIeU3Jkywej3XYkFZ6TL/w+te3QqSl4f8OsrzQKBgFlzcq+HCeXkJzDq0mr20sWzZi0dx9GuzUkJ/vykCMuB3yloQoY19o3K6PBacuGS6LUhpv07V8Xbr0U05HjsoCt+H/LejTkcS7/I743+7AR9w4D8rAV8MFLDICqrfmFTtubwHkxRMbEUvkbpl4fPBAW3NvtgCU9lLw5cyCGV5adnAoGBAIqCD948hPGIB5J+oOduMscZjRHH01NpVaXHFV29lMKva90xP//KtKZn0JPSBHb9lr+h4O4f5bA6vgbMSq3Vz8s14Tmy5KkT9X4wnubLN14tICcE6jaFbtphwUI08YyavvCxYgYZaeam6QZ115JckyU7EFWhkSu29SYhg1lFyACZAoGAb8Ox7dEJ0gKiFsLsGt87RQ4Ugts8m8r8KVy51DAfO/MoeUmhP+nd8cfo4Sk/pExsHB9xfvwYSItb2Dasm5XBZReOUuK1cnxy3UaOwatqpi0YaOhDxnkfIPEE6zXihfLkWadRbn6vyzqUBow+cUpVQCQUEUzJuvD7248dZ7X0+6w=",
		
		//异步通知地址
		'notify_url' => "http://工程公网访问地址/alipay.trade.wap.pay-PHP-UTF-8/notify_url.php",
		
		//同步跳转
		'return_url' => "http://mitsein.com/alipay.trade.wap.pay-PHP-UTF-8/return_url.php",

		//编码格式
		'charset' => "UTF-8",

		//签名方式
		'sign_type'=>"RSA2",

		//支付宝网关
		'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",

		//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
		'alipay_public_key' => "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyZhBmbH/xgmnJ2cvUi12+MPzcGAIpmB5GJ5hoCcVh14gYMjts0OeHMfr6ckSgsp99G1hu1LHRGZFsOgn/Z4wIUIs/c3JAIiegmBRVZNfw2Z5AmMVfsn8NNtFU8zSM6LzJnhnneYJtTwwTJ0Dbo0yHGmLkNSs+otvgmI4qb1GsdX9i+k1j5d7G+kMAVv6VBb4rALRahFxaFqpiFb6hIlzyPH1vBza6mc8IssZ+XBL+JV5jPG42i2c/zLf0FcI2T8l72qNtPZ5A1SH1s9001TZi/niE+S+47fnPsJCwUfgUVJvkM3BOAK+cIJ4dW0xYjWdfR2In/yqJtLckYIBnZYE/wIDAQAB",
		
	
);