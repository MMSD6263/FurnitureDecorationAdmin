        // 交易对 对象
        var tradeObj = {
            pair_trade_arr: [], //交易对数组
            // 数组格式：
            // {
            //     name:'火币',
            //     pairs:['btc_usdt','eth_usdt']
            // }
            //添加交易对标签
            addPairTradeTag: function (trade_key, trade_value) {
                var tagstr = '<span class="label label-info trade-tag" >' + trade_key + ' / ' + trade_value +
                    '<i class="fa fa-remove ori icon-remove" onclick="tradeObj.removePairTrade(this)"></i></span>';
                $('.js_trades').append(tagstr);
                $('.js_tips').hide();
            },
            // 删除交易对标签
            removePairTrade: function (dom) {
                var $parent = $(dom).parents('.label');

                var txt = $parent.text();
                var trade_arr = txt.split('/');
                console.log(trade_arr);
                var trade_key = $.trim(trade_arr[0]),
                    trade_value = $.trim(trade_arr[1]);

                for (var i = 0; i < this.pair_trade_arr.length; i++) {
                    var element = this.pair_trade_arr[i];
                    if (element.name == trade_key) {
                        // 账户仅有一个交易对
                        if (element.pairs.length == 1) {
                            this.pair_trade_arr.splice(i, 1);
                            $parent.remove();
                            break;
                        }
                        // 账户有多个交易对
                        var idx = element.pairs.indexOf(trade_value);
                        this.pair_trade_arr[i].pairs.splice(idx, 1);
                        $parent.remove();
                    }
                }
                console.log(this.pair_trade_arr);



            }
        };
        $(function () {
            // 激活tooltip提示框
            $("[data-toggle='tooltip']").tooltip();
            var $parents = $('#strategy_param'),
                $modal = $('#myModal');
            //添加策略
            $('#add_strategy_param').click(function () {
                var param_name = $parents.find('.js_param_name').val(),
                    param_describe = $parents.find('.js_param_describe').val(),
                    param_note = $parents.find('.js_param_note').val(),
                    // param_type=$parents.find('.js_param_type').val(),
                    param_default = $parents.find('.js_param_default').val();
                // var param_type_txt=$parents.find('.js_param_type option:selected').text();

                // 有未填项，则终止
                if (!param_name || !param_describe || !param_default) {
                    // $modal.modal('show');
                    $modal.find('.modal-body').text('除了备注所有项都是必填项').end().modal('show');
                    return;
                }

                var tagstr = '<tr>';
                tagstr += '<td>' + param_name + '</td>';
                tagstr += '<td>' + param_describe + '</td>';
                // tagstr+='<td>'+param_type_txt+'</td>';
                tagstr += '<td>' + param_default + '</td>';
                tagstr +=
                    '<td><a class="btn btn-default btn-xs js_edit" data-toggle="tooltip" title="复制变量到编辑框, 更改后点保存"><i class="fa fa-pencil ori"></i></a> <a class="btn btn-danger btn-xs js_del" data-toggle="tooltip" title="删除此功能"><i class="fa fa-remove ori"></i></a></td>';
                tagstr += '</tr>';



                // 参数对象
                var temp_obj = {
                    name: param_name,
                    info: {
                        param_name: param_name,
                        param_describe: param_describe,
                        param_note: param_note,
                        param_default: param_default
                    }
                }

                // 编辑-替换，添加-push
                var flag = 0;
                var $tr = $parents.find('tbody tr');
                var $in_edit = $parents.find('tbody .in-edit');

                for (var i = 0; i < $tr.length; i++) {
                    var $curtr = $tr.eq(i);
                    var identity = $.trim($curtr.find('td:first-child').text());
                    if (identity == param_name) {
                        flag = 1;
                        strategy_obj.params_arr.splice(i, 1, temp_obj);
                        $curtr.after(tagstr).remove();
                        if ($in_edit.length > 0) {
                            $modal.find('.modal-body').text('编辑完成').end().modal('show');
                        } else {
                            $modal.find('.modal-body').text('参数存在，已自动覆盖').end().modal('show');
                        }
                    }
                }
                if (!flag) {
                    strategy_obj.params_arr.push(temp_obj);
                    $parents.find('tbody').append(tagstr);
                }
                console.log(strategy_obj);

            })

            // 删除策略
            $('#strategy_param').on('click', '.js_del', function (e) {
                var $tr = $(this).parents('tr').remove();
                var name = $.trim($tr.find('td:first-child').text());

                for (var i = 0; i < strategy_obj.params_arr.length; i++) {
                    if (strategy_obj.params_arr[i].name == name) {
                        strategy_obj.params_arr.splice(i, 1);
                    }
                }
                console.log(strategy_obj);
            })

            // 编辑策略
            $('#strategy_param').on('click', '.js_edit', function (e) {
                $(this).parents('tbody').children('tr').removeClass('in-edit');
                var $tr = $(this).parents('tr').addClass('in-edit');
                var name = $.trim($tr.find('td:first-child').text());
                var params = strategy_obj.params_arr;
                for (var i = 0; i < params.length; i++) {
                    if (params[i].name == name) {
                        $parents.find('.js_param_name').val(params[i].info.param_name)
                            .end()
                            .find('.js_param_describe').val(params[i].info.param_describe)
                            .end()
                            .find('.js_param_note').val(params[i].info.param_note)
                            .end()
                            .find('.js_param_default').val(params[i].info.param_default);
                    }
                }
                console.log(strategy_obj);
            })

            // 添加机器人
            // 添加交易对
            $('#add_trades').click(function () {
                var $account = $('#trade_account'),
                    $pair_trade = $('#pair_trade');
                var trade_key = $.trim($account.find('option:selected').text()),
                trade_value = $.trim($pair_trade.find('option:selected').text()),
                trade_eid  = $account.find('option:selected').val();
                console.log(trade_eid);
                console.log(trade_key);
                console.log(trade_value);

                // 添加第一个交易对
                if (tradeObj.pair_trade_arr.length < 1) {
                    var temp_obj = {
                        name: trade_key,
                        pairs: [trade_value],
                        eid:trade_eid,
                    }
                    tradeObj.pair_trade_arr.push(temp_obj);
                    console.log(tradeObj);

                    // dom
                    tradeObj.addPairTradeTag(trade_key, trade_value);
                    $(this).removeClass('btn-danger').addClass('btn-success');
                    return;
                }

                //添加第2~n个交易对 
                var flag = 0;
                for (var i = 0; i < tradeObj.pair_trade_arr.length; i++) {
                    var element = tradeObj.pair_trade_arr[i];
                    if (element.name == trade_key) {
                        flag = 1;
                        for (var j = 0; j < element.pairs.length; j++) {
                            var cur_pair = element.pairs[j];
                            if (cur_pair == trade_value) {
                                // alert('该交易对已添加');
                                return;
                            }
                        }
                        tradeObj.pair_trade_arr[i].pairs.push(trade_value);
                    }
                }
                if (!flag) {
                    var temp_obj = {
                        name: trade_key,
                        pairs: [trade_value],
                        eid:trade_eid,
                    }
                    tradeObj.pair_trade_arr.push(temp_obj);
                }
                tradeObj.addPairTradeTag(trade_key, trade_value);
                console.log(tradeObj);
            })

            // 编辑机器人--显示隐藏
            $('.js_shown_btn').click(function () {
                $(this).toggleClass('ctrl');
                $('.js_show_hide').toggleClass('hidden');
            })

        })