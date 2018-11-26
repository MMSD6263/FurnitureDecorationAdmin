<?php
//网站配置
return [
    '6'          => 'bian',       //币安
    '11'         => 'okex',       //okex
    '10'         => 'huobi',       //火币
    'zabbix_url' => 'http://128.1.135.248:82/',// url 跳转
    'go_port'=>10001,                         //go  服务器
    'web'        => [
        'admin/asset/account'                     => '账户信息',
        'admin/asset/accountData'                 => '交易账户',
        'admin/asset/ajaxAccountData'             => '异步数据交互',
        'admin/asset/ajaxData'                    => '获取异步数据',
        'admin/asset/ajaxExchangeData'            => '交易所数据',
        'admin/asset/downloadData'                => '下载数据',
        'admin/asset/exchange'                    => '交易所',
        'admin/asset/index'                       => '首页列表',
        'admin/backtest/add'                      => '添加回测数据',
        'admin/backtest/ajaxData'                 => '添加回测数据',
        'admin/backtest/index'                    => '回测列表首页',
        'admin/clouddata/downLoadData'            => '云数据下载',
        'admin/clouddata/index'                   => '云列表',
        'admin/coin/ajaxData'                     => '币种数据',
        'admin/coin/changeStatus'                 => '币种状态',
        'admin/coin/index'                        => '币种首页列表',
        'admin/currency/ajaxData'                 => '首页展示',
        'admin/currency/index'                    => '数据保存',
        'admin/exchange/ajaxData'                 => '异步数据',
        'admin/exchange/index'                    => '账号列表首页',
        'admin/exchangeaccount/accountData'       => '交易账号信息',
        'admin/exchangeaccount/ajaxData'          => '交易账号列表',
        'admin/exchangeaccount/distributeUser'    => '分配用户',
        'admin/exchangeaccount/exchangeInfo'      => '交易所信息',
        'admin/exchangeaccount/index'             => '交易账号首页',
        'admin/exchangeaccount/saveData'          => '保存数据',
        'admin/exchangeaccount/setThresholdValue' => '设置各个账户资金的阈值',
        'admin/index'                             => '加载框架首页',
        'admin/index_v1'                          => '首页',
        'admin/log/ajaxData'                      => '日志数据',
        'admin/log/index'                         => '日志',
        'admin/login'                             => '登录',
        'admin/logout'                            => '退出',
        'admin/markdown/directoryInfo'            => '文档展示',
        'admin/markdown/index'                    => '文档首页',
        'admin/markdown/saveData'                 => '保存文档',
        'admin/operatelog/ajaxData'               => '日志列表数据',
        'admin/operatelog/index'                  => '日志列表数据',
        'admin/operating/accountbalance'          => '运营列表账户余额',
        'admin/operating/ajaxAccountData'         => '运营列表账户详情',
        'admin/operating/ajaxPlatformsData'       => '运营交易平台数据',
        'admin/operating/ajaxTotalBalanceData'    => '运营总余额',
        'admin/operating/cointotal'               => '运营货币总额',
        'admin/operating/platformsbalance'        => '运营交易平台余额',
        'admin/page/configuration'                => '测试',
        'admin/page/robot'                        => '测试',
        'admin/powers/add'                        => '添加节点',
        'admin/powers/ajaxData'                   => '节点列表数据',
        'admin/powers/edit'                       => '修改',
        'admin/powers/index'                      => '列表',
        'admin/powers/powertree'                  => '获取树状数据',
        'admin/recharge/ajaxData'                 => '数据列表',
        'admin/recharge/index'                    => '首页',
        'admin/role/ajaxdata'                     => '获取权限节点列表数据',
        'admin/role/edit'                         => '修改权限节点',
        'admin/role/index'                        => '权限节点列表',
        'admin/role/subedit'                      => '修改节点',
        'admin/server/ajaxData'                   => '服务器列表数据',
        'admin/server/detail'                     => '服务器详情信息页面',
        'admin/server/index'                      => '服务器首页',
        'admin/server/serverInfo'                 => '服务器详情',
        'admin/strategy/addStrategy'              => '添加策略',
        'admin/strategy/ajaxDataDetails'          => '回测详情数据',
        'admin/strategy/backTestData'             => '保存回测数据',
        'admin/strategy/backTestStatus'           => '获取回测机器人状态',
        'admin/strategy/changeStrategyStatus'     => '变更策略状态',
        'admin/strategy/createChild'              => '添加子版本',
        'admin/strategy/getBackTestData'          => '策略回滚',
        'admin/strategy/getVersion'               => '获取版本',
        'admin/strategy/index'                    => '首页',
        'admin/strategy/saveBacktestData'         => '保存回测数据',
        'admin/strategy/saveStrategyData'         => '保存策略',
        'admin/strategy/strategyData'             => '策略列表',
        'admin/task/ajaxData'                     => '获取数据列表',
        'admin/task/ajaxDataDetails'              => '机器人详情',
        'admin/task/delData'                      => '删除机器人',
        'admin/task/delLog'                       => '删除机器人日志',
        'admin/task/editTask'                     => '编辑任务',
        'admin/task/getStrategyInfo'              => '获取策略信息',
        'admin/task/getTradePair'                 => '获取交易对',
        'admin/task/index'                        => '首页展示',
        'admin/task/openSupervising'              => '开启监控',
        'admin/task/process'                      => '机器人进程状态',
        'admin/task/saveTaskData'                 => '保存任务数据',
        'admin/task/searchAndDownload'            => '用户下载页面',
        'admin/task/taskLog'                      => '机器人日志',
        'admin/template/ajaxData'                 => '获取模板异步数据',
        'admin/template/index'                    => '模板首页',
        'admin/user/ajaxData'                     => '用户详情',
        'admin/user/index'                        => '用户列表',
    ],
];