layui.define(['layer', 'jquery','websocket'], function(exports) {
    "use strict";

    var Webim = function() {
            this.v = '1.1';
        },
        _MOD = 'webim',
        _this = this,
        layer = layui.layer,
        $ = layui.jquery,
        WebSocket =layui.websocket,
        kf_id = 0,
        kf_name = '',
        socket = null,
        uinfo = null,//用户信息
        time = 0,
        timer = 0,//通知定时器
        config = {};
	    var stope = layui.stope; //组件事件冒泡
          //表情库
		var faces = function(){
			var alt = ["[微笑]", "[嘻嘻]", "[哈哈]", "[可爱]", "[可怜]", "[挖鼻]", "[吃惊]", "[害羞]", "[挤眼]", "[闭嘴]", "[鄙视]", "[爱你]", "[泪]", "[偷笑]", "[亲亲]", "[生病]", "[太开心]", "[白眼]", "[右哼哼]", "[左哼哼]", "[嘘]", "[衰]", "[委屈]", "[吐]", "[哈欠]", "[抱抱]", "[怒]", "[疑问]", "[馋嘴]", "[拜拜]", "[思考]", "[汗]", "[困]", "[睡]", "[钱]", "[失望]", "[酷]", "[色]", "[哼]", "[鼓掌]", "[晕]", "[悲伤]", "[抓狂]", "[黑线]", "[阴险]", "[怒骂]", "[互粉]", "[心]", "[伤心]", "[猪头]", "[熊猫]", "[兔子]", "[ok]", "[耶]", "[good]", "[NO]", "[赞]", "[来]", "[弱]", "[草泥马]", "[神马]", "[囧]", "[浮云]", "[给力]", "[围观]", "[威武]", "[奥特曼]", "[礼物]", "[钟]", "[话筒]", "[蜡烛]", "[蛋糕]"], arr = {};
			layui.each(alt, function(index, item){
			  arr[item] = layui.cache.dir + 'images/face/'+ index + '.gif';
			});
			return arr;
		}();

		var a = {
			init: function () {
	            var protocol = location.protocol === 'https:' ? 'wss://' : 'ws://';
	            socket = new ReconnectingWebSocket(protocol + config.domain+ ':'+ config.port+'?module=admin&token='+config.token.admin_token);//创建Socket实例
                //连接成功建立的回调方法
	            socket.onopen = function (res) {
			        layer.ready(function () {
			            layer.msg('链接成功', {time: 1000});
			        });

	                // 登录
                    var login_data = '{"type":"init", "uid":"' + config.uid + '", "name" : "' + config.name + '", "avatar" : "'+ config.avatar + '", "group": ' + config.group + '}';
                    socket.send(login_data);
	                a.ping(30000);
	                a.isLock(false);
	            };
	            //接收到消息的回调方法
	            socket.onmessage = function (res) {
	                var data = $.parseJSON(res.data);
	                switch(data['message_type']){
				        // 服务端ping客户端
				        case 'ping':
				            socket.send('{"type":"ping"}');
				            break;
				        // 添加用户
				        case 'connect':
				            a.addUser(data.data.user_info);
				            break;
				        // 移除访客到主面板
				        case 'delUser':
				            a.delUser(data.data);
				            break;
				        // 监测聊天数据
				        case 'chatMessage':
				            a.showUserMessage(data.data, data.data.content);
				            break;
				        // 用户被清理
		                case 'clear':
		                    socket.close();
		                    a.isLock(true);
		                    $('#chat-title').html('链接已经中断');
		                    break;
				        case 'close':
				            a.loginOut();
				            break;
	                }

	            };
	            //连接关闭的回调方法
	            socket.onclose = function (err) {
	                console.log('连接断开');
	            };
	            //连接发生错误的回调方法
	            socket.onerror = function () {
	                console.log("连接异常");
	            };
			},
	        event: function() {
	            // 点击发送消息
	            $('#send').click(function(){
	                a.sendMsg();
	            });
	            $('body').on('click', '*[webim-event]', function(e){
	            	var othis = $(this), methid = othis.attr('webim-event');
	            	b[methid] ? b[methid].call(this, othis, e) : '';
	            });
			    // 如果没有选中人，选中第一个
			    var hasActive = 0;
			    $("#user_list li").each(function(){
			        if($(this).hasClass('active')){
			            hasActive = 1;
			        }
			    });
	            b.hotkeySend();
	            a.checkUser();
	        },
			ping: function (time) {
	            //每30秒ping服务器
	            setInterval(function(){
	                socket.send('{"type":"ping"}');
	            },time);
			},
	        sendMsg: function(sendMsg) {
	            (typeof($('#msg-area').attr('readonly')) == 'undefined')?this.isLock(false):this.isLock(true);
	            var msg = (typeof(sendMsg) == 'undefined') ? $('#msg-area').val() : sendMsg;
	            if('' == msg){
	                layer.msg('请输入信息');
	                return false;
	            };
	            var content = this.replaceContent(msg); 
	            var time = this.getDate(); 
	            var word = this.msgFactory(content, 'mine',config);
	            var uid = $("#active-user").attr('data-id');
                var name = $("#active-user").attr('data-name');

	            // 发送消息
	            socket.send(JSON.stringify({
	                type: 'chatMessage',
	                data: {to_id: uid, to_name: name, content: msg, from_name: config.name,
	                    from_id: config.uid, from_avatar: config.avatar}
	            }));
	            $("#webim-chat-list ul").append(word);
	            $('#msg-area').val('');
	            // 滚动条自动定位到最底端
	            //showBigPic();
	            this.wordBottom();
	        },
			// 删除用户聊天面板
			delUser: function(data) {
			    $("#f-" + data.id).remove(); // 清除左侧的用户列表
			    $('#u-' + data.id).remove(); // 清除右侧的聊天详情
			},
	        msgFactory: function(content, type,info) {
	            var _html = '';
                if ('mine' == type) {
                    _html += '<li class="webim-chat-mine">';
                } else{
                    _html += '<li>';
                }
                _html += '<div class="webim-chat-user">';
                _html += '<img src="' + info.avatar + '">';
                if ('mine' == type) {
                    _html += '<cite><i>'+ a.getDate() + '</i>' + info.name + '</cite>';
                } else {
                    _html += '<cite>' + info.name + '<i>' + a.getDate() + '</i></cite>';
                }
                _html += '</div><div class="webim-chat-text">' + content + '</div>';
                _html += '</li>'; 
	            return _html;
	        },
	        // 获取天数
	        mGetDate: function() {
	            return Math.ceil(( new Date() - new Date(new Date().getFullYear().toString()))/(24*60*60*1000))+1;
	        },
	        // 获取当前分钟
	        getMinutes: function() {
	            var d = new Date(new Date());
	            var hour = 60;//1小时
	            var day = 24*hour;//1天
	            var totalDay = this.mGetDate()-1;//共多少天
	            var totalHour = this.digit(d.getHours());
	            var totalMinutes = this.digit(d.getMinutes());
	            return totalDay*day+totalHour*hour+totalMinutes;
	        },
	        // 获取日期
	        getDate: function() {
	            var d = new Date(new Date());
	            return d.getFullYear() + '-' + this.digit(d.getMonth() + 1) + '-' + this.digit(d.getDate())
	                + ' ' + this.digit(d.getHours()) + ':' + this.digit(d.getMinutes()) + ':' + this.digit(d.getSeconds());
	        },
	        // 日期转时间戳
	        getTimeS: function(argument) {
	            var timeS = argument;
	            timeS = timeS.replace(/[年月]/g,'/').replace(/[日]/,'');
	            return new Date().getTime() - new Date(timeS).getTime() - 1000; //有一秒的误差
	        },
	        //补齐数位
	        digit: function(num) {
	            return num < 10 ? '0' + (num | 0) : num;
	        },
	        // 对话框定位到最底端
	        wordBottom: function() {
	            var ex = $("#webim-chat-list");
	            ex.scrollTop(ex[0].scrollHeight);
	        },
	        // 转义聊天内容中的特殊字符
	        replaceContent: function(content) {
	            // 支持的html标签
	            var html = function (end) {
	                return new RegExp('\\n*\\[' + (end || '') + '(pre|div|span|p|table|thead|th|tbody|tr|td|ul|li|ol|li|dl|dt|dd|h2|h3|h4|h5)([\\s\\S]*?)\\]\\n*', 'g');
	            };
	            content = (content || '').replace(/&(?!#?[a-zA-Z0-9]+;)/g, '&amp;')
	                .replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/'/g, '&#39;').replace(/"/g, '&quot;') // XSS
	                .replace(/face\[([^\s\[\]]+?)\]/g, function (face) {  // 转义表情
	                    var alt = face.replace(/^face/g, '');
	                    return '<img alt="'+ alt +'" title="'+ alt +'" src="' + faces[alt] + '">';
	                })
	                .replace(/img\[([^\s]+?)\]/g, function (img) {  // 转义图片
	                    return '<img class="laykefu-img" src="' + img.replace(/(^img\[)|(\]$)/g, '') + '" width="100px" height="100%">';
	                })
	                .replace(/file\([\s\S]+?\)\[[\s\S]*?\]/g, function (str) { // 转义文件
	                    var href = (str.match(/file\(([\s\S]+?)\)\[/) || [])[1];
	                    var text = (str.match(/\)\[([\s\S]*?)\]/) || [])[1];
	                    if (!href) return str;
	                    return '<a class="laykefu-file" href="' + href + '" download target="_blank"><i class="layui-icon">&#xe61e;</i><cite>' + (text || href) + '</cite></a>';
	                }).replace(html(), '\<$1 $2\>').replace(html('/'), '\</$1\>') // 转移HTML代码
	                .replace(/\n/g, '<br>') // 转义换行
	            return content;
	        },
			// 添加用户到面板
			addUser: function(data){
				//console.log(data);
				var add = true;
				$('.layui-nav-item').each(function(i){
					if(parseInt($(this).attr('data-id'))==data.id) {
						add =  false;
					}
				});
				if(add){
				    var _html = '<li class="layui-nav-item" data-id="' + data.id + '" id="f-' + data.id +
				        '" data-name="' + data.name + '" data-avatar="' + data.avatar + '" data-ip="' + data.ip + '">';
				    _html += '<img src="' + data.avatar + '">';
				    _html += '<span class="user-name">' + data.name + '</span>';
				    _html += '<span class="layui-badge" style="margin-left:5px">0</span>';
				    _html += '<i class="layui-icon close" style="display:none">ဇ</i>';
				    _html += '</li>';
				    // 添加左侧列表
				    $("#user_list").append(_html);

				    // 如果没有选中人，选中第一个
				    var hasActive = 0;
				    $("#user_list li").each(function(){
				        if($(this).hasClass('active')){
				            hasActive = 1;
				        }
				    });

				    var _html2 = '';
				    _html2 += '<ul id="u-' + data.id + '">';
				    _html2 += '</ul>';
				    // 添加主聊天面板
				    $('.chat-box').append(_html2);

				    if(0 == hasActive){
				        $("#user_list").find('li').eq(0).addClass('active').find('span:eq(1)').removeClass('layui-badge').text('');
				        $("#u-" + data.id).show();

				        var id = $(".layui-unselect").find('li').eq(0).data('id');
				        var name = $(".layui-unselect").find('li').eq(0).data('name');
				        var ip = $(".layui-unselect").find('li').eq(0).data('ip');
				        var avatar = $(".layui-unselect").find('li').eq(0).data('avatar');

				        // 设置当前会话用户
				        $("#active-user").attr('data-id', id).attr('data-name', name).attr('data-avatar', avatar).attr('data-ip', ip);

				        /*$("#f-user").val(name);
				        $("#f-ip").val(ip);*/

				        /*$.getJSON('/Houtailogin/chat/getCity', {ip: ip}, function(res){
				            $("#f-area").val(res.data);
				        });*/
				    }

				    a.getChatLog(data.id, 1);
				    a.checkUser();
				}

			},
			// 操作新连接用户的 dom操作
			checkUser: function() {
			    $(".layui-unselect").find('li').unbind("click"); // 防止事件叠加
			    // 切换用户
			    $(".layui-unselect").find('li').bind('click', function () {
			        a.changeUserTab($(this));
			        var uid = $(this).data('id');
			        var avatar = $(this).data('avatar');
			        var name = $(this).data('name');
			        var ip = $(this).data('ip');
			        // 展示相应的对话信息
			        $('.chat-box ul').each(function () {
			            if ('u-' + uid == $(this).attr('id')) {
			                $(this).addClass('show-chat-detail').siblings().removeClass('show-chat-detail').attr('style', '');
			                return false;
			            }
			        });

			        // 去除消息提示
			        $(this).find('span').eq(1).removeClass('layui-badge').text('');

			        // 设置当前会话的用户
			        $("#active-user").attr('data-id', uid).attr('data-name', name).attr('data-avatar', avatar).attr('data-ip', ip);

			        // 右侧展示详情
			        /*$("#f-user").val(name);
			        $("#f-ip").val(ip);
			        $.getJSON('/service/index/getCity', {ip: ip}, function(res){
			            $("#f-area").val(res.data);
			        });*/
			        a.getChatLog(uid, 1);
			        a.wordBottom();
			    });
			},
			// 切换在线用户
			changeUserTab: function(obj) {
			    obj.addClass('active').siblings().removeClass('active');
			    a.wordBottom();
			},
			// 获取聊天记录
			getChatLog: function(uid, page, flag) {

			},
			// 展示客户发送来的消息
			showUserMessage: function(uinfo, content) {
			    if ($('#f-' + uinfo.id).length == 0) {
			        a.addUser(uinfo);
			    }

			    // 未读条数计数
			    if (!$('#f-' + uinfo.id).hasClass('active')) {
			        var num = $('#f-' + uinfo.id).find('span:eq(1)').text();
			        if (num == '') num = 0;
			        num = parseInt(num) + 1;
			        $('#f-' + uinfo.id).find('span:eq(1)').removeClass('layui-badge').addClass('layui-badge').text(num);
			    }
			    content = a.replaceContent(content);
			    var word = a.msgFactory(content, 'user', uinfo);
			    setTimeout(function () {
			        $("#u-" + uinfo.id).append(word);
			        // 滚动条自动定位到最底端
			        a.wordBottom();
			        //showBigPic();
			    }, 200);
			},
			// 操作新连接用户的 dom操作
			checkUser: function(){
			    $(".layui-unselect").find('li').unbind("click"); // 防止事件叠加
			    // 切换用户
			    $(".layui-unselect").find('li').bind('click', function () {
			        a.changeUserTab($(this));
			        var uid = $(this).data('id');
			        var avatar = $(this).data('avatar');
			        var name = $(this).data('name');
			        var ip = $(this).data('ip');
			        // 展示相应的对话信息
			        $('.chat-box ul').each(function () {
			            if ('u-' + uid == $(this).attr('id')) {
			                $(this).addClass('show-chat-detail').siblings().removeClass('show-chat-detail').attr('style', '');
			                return false;
			            }
			        });

			        // 去除消息提示
			        $(this).find('span').eq(1).removeClass('layui-badge').text('');

			        // 设置当前会话的用户
			        $("#active-user").attr('data-id', uid).attr('data-name', name).attr('data-avatar', avatar).attr('data-ip', ip);

			        // 右侧展示详情
			        //$("#f-user").val(name);
			        //$("#f-ip").val(ip);
			        /*$.getJSON('/service/index/getCity', {ip: ip}, function(res){
			            $("#f-area").val(res.data);
			        });*/

			        a.getChatLog(uid, 1);

			        a.wordBottom();
			    });
			},
	        //锁住聊天窗口
	        isLock: function(state) {
	            state?($('#msg-area').attr('readonly', 'readonly')):$('#msg-area').removeAttr('readonly');
	        },
		};

        var b={
			//设置发送聊天快捷键
		    setSend: function(othis, e){
		      //var box = events.setSend.box = othis.siblings('.layim-menu-box');
		      var type = othis.attr('lay-type');
		      var othis = $(this);
		      if(type === 'show'){
                  stope(e);
                  $('.webim-menu-box').show().addClass('layui-anim-upbit');
                  $(document).off('click', b.setSendHide).on('click', b.setSendHide);
		      }else{
		      	  othis.addClass('webim-this').siblings().removeClass('webim-this');
			        layui.data('webim', {
			          key: 'sendHotKey'
			          ,value: type
			      });
                  b.setSendHide();
		      }
		    },
			setSendHide: function(e, box){
			     $('.webim-menu-box').hide().removeClass('layui-anim-upbit');
			},
			//快捷键发送
			hotkeySend: function(){
			    $('#msg-area').focus();
			    $('#msg-area').off('keydown').on('keydown', function(e){
			      var sendHotKey = layui.data('webim').sendHotKey || '';
			      var keyCode = e.keyCode;
			      if(sendHotKey === 'Ctrl+Enter'){
			        if(e.ctrlKey && keyCode === 13){
			          a.sendMsg();
			        }
			        return;
			      }
			      if(keyCode === 13){
			        if(e.ctrlKey){
			          return $('#msg-area').val($('#msg-area').val()+'\n');
			        }
			        if(e.shiftKey) return;
			            e.preventDefault();
			            a.sendMsg();
			      }
			    });
			},
			face: function(othis, e){
				var content = '';
				for(var key in faces){
				   content += '<li title="'+ key +'"><img src="'+ faces[key] +'"></li>';
				}
				content = '<ul class="layui-clear webim-face-list">'+ content +'</ul>';
				b.face.index =layer.tips(content, othis, {
					tips: 1
					,time: 0
					,fixed: true
					,skin: 'layui-box layui-webim-face'
					,success: function(layero){
						layero.find('.webim-face-list>li').on('mousedown', function(e){
						  stope(e);
						}).on('click', function(){
							$("#msg-area").val('face' +  this.title + ' ');
						layer.close(b.face.index);
						});
					}
				})
				$(document).off('mousedown', b.faceHide).on('mousedown', b.faceHide);
				$(window).off('resize', b.faceHide).on('resize', b.faceHide);
				stope(e);
		    },faceHide: function(){
		      layer.close(b.face.index);
		    }
        };

        /*Webim.prototype.render = function(options){
	        options.avatar = options.avatar || 'https://cdn.jsdelivr.net/gh/ken678/demo@master/kefu/service.png',//用户头像
	        config = options;
	        a.init();
	        a.event();
	        return new Webim();
        };*/

        Webim.prototype.render = function(options){
			var protocol = window.location.protocol + '//';
			$.ajax({
				type: "GET",
				url: protocol + options.domain+'/webim/init/index?module=admin',
				dataType: "json",
				success: function(res){
	                if (res.code != 1) {
	                    layer.msg('初始化失败，请刷新重试！');
	                    return;
	                }
	                config = res.data;
					config.domain = options.domain;
					
					config.uid = config.info.id;
					config.name = config.info.nickname;
					config.avatar = config.info.avatar || 'https://cdn.jsdelivr.net/gh/ken678/demo@master/kefu/service.png';
					config.group = options.group || 1;
					a.init();
					a.event();
				}
			});
	        return new Webim();
        };

		//获取所有缓存数据
		Webim.prototype.cache = function(){
		    return cache;
		};

    var webim = new Webim();
    exports(_MOD, webim);
});