layui.define(['layer', 'jquery','websocket','carousel'], function(exports) {
    "use strict";

    var Webim = function() {
            this.v = '1.1';
        },
        _MOD = 'webim',
        _this = this,
        layer = layui.layer,
        $ = layui.jquery,
        carousel = layui.carousel,
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
		carousel.render({
			elem: '#lunbo',
			width: '100%'
		});

		var a = {
			check: function(){
		        if('' == config.domain || 0 == config.group || '' == config.port){
		            console.log("配置文件错误");
		            return false;
		        }
		        var sendHotKey = layui.data('webim').sendHotKey || '';
		        if(sendHotKey === 'Ctrl+Enter'){
		        	$('.webim-menu-box li.webim-this').removeClass('webim-this').siblings().addClass('webim-this');
		        }
		        if (!a.getCache('nowMinutes')) {//显示消息时间
		            a.cacheChat({key:"nowMinutes",data:{'now':a.getMinutes()}}); 
		        } 
			},
			init: function () {
				a.check();
	            var protocol = location.protocol === 'https:' ? 'wss://' : 'ws://';
	            socket = new ReconnectingWebSocket(protocol + config.domain+ ':'+ config.port+'?module=index&token='+config.token.visitors_token);//创建Socket实例
	            //uinfo = a.getCache('kefu-id');
	            uinfo = config.info;
	            //连接成功建立的回调方法
	            socket.onopen = function (res) {
	                var login_data = '{"type":"userInit", "uid": "' + uinfo.id + '", "name" : "' + uinfo.name + '", "avatar" : "' + uinfo.avatar + '", "group" : "' + config.group + '"}';
	                socket.send(login_data);
	                a.ping(30000);
	                a.isLock(false);
	            };
	            //接收到消息的回调方法
	            socket.onmessage = function (res) {
	                var data = $.parseJSON(res.data);
	                switch(data['message_type']){
		                // 已经被分配了客服
		                case 'connect':
		                    kf_id = data.data.kf_id;
		                    kf_name = data.data.kf_name;
		                    a.showSystem({content: '客服 ' + kf_name + ' 为您服务'});
		                    $('#chat-title').html('与 ' + kf_name + ' 交流中');
		                    a.showChatLog();
		                    break;
		                // 监测客服上线
		                case 'kf_online':
		                    if (data.data.kf_group == config.group) {
		                        kf_id = data.data.kf_id;
		                        kf_name = data.data.kf_name;
		                        $('#laykefu-title').html('与 ' + kf_name + ' 交流中');
		                        a.showSystem({content: '客服 ' + kf_name + ' 为您服务'});
		                        a.wordBottom();
		                        a.isLock(false);
		                    }
		                    break; 
		                // 监测客服上线
		                case 'kf_online':
		                    if (data.data.kf_group == config.group) {
		                        kf_id = data.data.kf_id;
		                        kf_name = data.data.kf_name;
		                        $('#chat-title').html('与 ' + kf_name + ' 交流中');
		                        a.showSystem({content: '客服 ' + kf_name + ' 为您服务'});
		                        a.wordBottom();
		                        a.isLock(false);
		                    }
		                    break;
		                // 监测聊天数据                
		                case 'chatMessage':
		                    a.showMsg(data.data);
		                    break;
				        // 排队等待
		                case 'wait':
		                    a.isLock(true);
		                    $('#chat-title').html('暂时没有客服');
		                    a.showSystem(data.data);
		                    break;
				        // 用户被清理
		                case 'clear':
		                    socket.close();
		                    a.isLock(true);
		                    $('#chat-title').html('链接已经中断');
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
	            b.hotkeySend();
	        },
			ping: function (time) {
	            //每30秒ping服务器
	            setInterval(function(){
	                socket.send('{"type":"ping"}');
	            },time);
			},
			showChatLog: function(){// 展示本地聊天缓存
		        var chatLog = a.getCache(kf_id + '-' + uinfo.id);
		        if(chatLog == null || chatLog.length == 0){
		            return ;
		        }
		        var _html = '';
		        var len = chatLog.length;
		        for(var i = 0; i < len; i++){
		            var v = chatLog[i];
		            if ('time' !== v.type) {
		                if ('mine' == v.type) {
		                    _html += '<li class="webim-chat-mine">';               
		                } else {
		                    _html += '<li>';               
		                }
		                _html += '<div class="webim-chat-user">';
		                _html += '<img src="' + v.avatar + '">'; 
		                if ('mine' == v.type) {
		                    _html += '<cite><i>'+ a.getDate() + '</i>' + v.name + '</cite>';
		                } else {
		                    _html += '<cite>' + v.name  + '<i>' + a.getDate() + '</i></cite>';
		                }
		                _html += '</div><div class="webim-chat-text">' + v.content + '</div>';
		                _html += '</li>';
		            }else{
		                var data = a.getTimeText(v.time); 
		                _html += '<div class="webim-chat-system"><span>' + data + '</span></div>';
		            }
		        }
		        $("#webim-chat-list ul").append(_html);
		        //showBigPic();
		        // 滚动条自动定位到最底端
		        a.wordBottom();
			},
			showMsg: function(info){// 展示收到的消息
		        // 清除系统消息
		        $('.webim-chat-system').html('');
		        a.clearMsg();//清除已有提醒
		        var _html = $('#webim-chat-list').html();
		        var content = a.replaceContent(info.content);
		        var word = a.msgFactory(content, 'other',info.time,info);
		        $("#webim-chat-list ul").append(word);
		        /*if ($('#webim').css('display') == 'none') {
		            a.notice(true);
		        }*/
		        document.hidden && a.newMsg();
		        //a.showBigPic();
		        a.wordBottom();
			},
			newMsg: function(){//消息提醒
			    var title = document.title.replace("【　　　】", "").replace("【新消息】", "");  
			    // 定时器，设置消息切换频率闪烁效果就此产生  
			    timer = setTimeout(function () {  
			        time++;  
			        a.newMsg();
			        if (time % 2 == 0) {  
			            document.title = "【新消息】" + title  
			        }  
			        else {  
			            document.title = "【　　　】" + title  
			        };  
			    }, 600);  
			    return timer;
			},
			clearMsg: function(){// 清除消息提示
			    clearTimeout(timer);  
			    document.title = document.title.replace("【　　　】", "").replace("【新消息】", ""); 
			},
	        showTime: function(msg) {},
	        showSystem: function(msg) {
	            var _html = '<div class="webim-chat-system"><span>' + msg.content + '</span></div>';
	            $("#webim-chat-list ul").append(_html);
	        },
	        sendMsg: function(sendMsg) {
		        if (!socket || socket.readyState != 1) {
		            layer.msg('网络链接异常，请刷新重试~');
		            return false;
		        }
	            //(typeof($('#msg-area').attr('readonly')) == 'undefined')?this.isLock(false):this.isLock(true);
	            var msg = (typeof(sendMsg) == 'undefined') ? $('#msg-area').val() : sendMsg;
	            if('' == msg){
	                layer.msg('请输入信息');
	                return false;
	            };
	            var content = this.replaceContent(msg); 
	            var time = this.getDate(); 
	            var word = this.msgFactory(content, 'mine',time,uinfo);
	            // 发送消息
	            socket.send(JSON.stringify({
	                type: 'chatMessage',
	                data: {to_id: kf_id, to_name: kf_name, content: msg, from_name: uinfo.name,
	                    from_id: uinfo.id, from_avatar: uinfo.avatar}
	            }));
	            $("#webim-chat-list ul").append(word);
	            $('#msg-area').val('');
	            // 滚动条自动定位到最底端
	            //showBigPic();
	            this.wordBottom();
	        },
	        msgFactory: function(content, type, time, info) {
	            // 储存信息
	            var key = kf_id + '-' + uinfo.id;
	            if(typeof(Storage) !== "undefined"){
	                var localMsg = a.getCache(key);
	                if($.isEmptyObject(localMsg) == true || localMsg == null || localMsg.length == 0){
	                    localMsg = [];
	                }
	                type == 'mine' ? name = '我':name = info.name;
	                if (a.getCache('nowMinutes').now != a.getMinutes()) {//消息发送接收时间大于当前记录时间
	                    var data = {}; 
	                    data.content = a.getTimeText(time);
	                    a.showSystem(data);
	                    localMsg.push({type: 'time', time: time,});
	                    a.cacheChat({key:"nowMinutes",data:{'now':a.getMinutes()}});//更新时间
	                }
	                localMsg.push({type: type, name: name, time: time, content: content,avatar:info.avatar});
	                a.cacheChat({key: key, data: localMsg});
	            }        
	            var _html = '';
	            if ('time' !== type) {
	                if ('mine' == type) {
	                    _html += '<li class="webim-chat-mine">';
	                } else{
	                    _html += '<li>';
	                }
	                _html += '<div class="webim-chat-user">';
	                _html += '<img src="' + info.avatar + '">';
	                if ('mine' == type) {
	                    _html += '<cite><i>'+ a.getDate() + '</i>' + name + '</cite>';
	                } else {
	                    _html += '<cite>' + info.name + '<i>' + a.getDate() + '</i></cite>';
	                }
	                _html += '</div><div class="webim-chat-text">' + content + '</div>';
	                _html += '</li>'; 
	            }else{
	                _html = '<div class="webim-chat-system"><span>' + data.content + '</span></div>';            
	            }
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
	        getCache: function(key) {
	            return JSON.parse(localStorage.getItem(key));
	        },
	        cacheChat: function(obj) {
	            if(typeof(Storage) !== "undefined"){
	                localStorage.setItem(obj.key, JSON.stringify(obj.data));
	            }
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
	        getTimeText: function(time) {
	            var timeS = time;
	            var todayT = ''; //
	            var yestodayT = '';
	            var d = new Date(new Date());
	            var year = '';
	            var month = '';
	            var day = '';
	            var timeCha = this.getTimeS(timeS);
	            timeS = timeS.slice(-8);
	            year = time.slice(0,4);
	            month = time.slice(5,7);
	            day = time.slice(8,10);
	            todayT = this.digit(d.getHours())*60*60*1000 + this.digit(d.getMinutes())*60*1000 + this.digit(d.getSeconds())*1000;
	            yestodayT = todayT + 24*60*60*1000;
	            if(timeCha > yestodayT) {
	                if(year < d.getFullYear() ){
	                    return timeS.slice(0,2)>12?year+'年'+month+'月'+day+'日'+' 下午'+(timeS.slice(0,2)==12 ? 12 : timeS.slice(0,2) - 12)+timeS.slice(2,5):year+'年'+month+'月'+day+'日'+' 上午'+timeS.slice(0,5);
	                }else{
	                    return timeS.slice(0,2)>12?month+'月'+day+'日'+' 下午'+(timeS.slice(0,2)==12 ? 12 : timeS.slice(0,2) - 12)+timeS.slice(2,5):month+'月'+day+'日'+' 上午'+timeS.slice(0,5);
	                }
	                
	            }
	            if(timeCha > todayT && timeCha < yestodayT) {
	                return '昨天 '+timeS.slice(0,5);
	            }
	            if(timeCha < todayT) {
	                return timeS.slice(0,5);
	            }
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
	                    return '<img class="kefu-img" src="' + img.replace(/(^img\[)|(\]$)/g, '') + '" width="100px" height="100%">';
	                })
	                .replace(/file\([\s\S]+?\)\[[\s\S]*?\]/g, function (str) { // 转义文件
	                    var href = (str.match(/file\(([\s\S]+?)\)\[/) || [])[1];
	                    var text = (str.match(/\)\[([\s\S]*?)\]/) || [])[1];
	                    if (!href) return str;
	                    return '<a class="kefu-file" href="' + href + '" download target="_blank"><i class="layui-icon">&#xe61e;</i><cite>' + (text || href) + '</cite></a>';
	                }).replace(html(), '\<$1 $2\>').replace(html('/'), '\</$1\>') // 转移HTML代码
	                .replace(/\n/g, '<br>') // 转义换行
	            return content;
	        },
	        //锁住聊天窗口
	        isLock: function(state) {
	            state?($('#msg-area').attr('readonly', 'readonly')):$('#msg-area').removeAttr('readonly');
	        },
		};

	    var b={
			//设置发送聊天快捷键
		    setSend: function(othis, e){
		      //var box = events.setSend.box = othis.siblings('.webim-menu-box');
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

        Webim.prototype.render = function(options){
			var protocol = window.location.protocol + '//';
			$.ajax({
				type: "GET",
				url: protocol + options.domain+'/webim/init/index?module=index',
				dataType: "json",
				success: function(res){
	                if (res.code != 1) {
	                    layer.msg('初始化失败，请刷新重试！');
	                    return;
	                }
	                config = res.data;
					config.domain = options.domain;
					
					config.info.avatar = config.info.avatar || 'https://cdn.jsdelivr.net/gh/ken678/demo@master/kefu/visitor.png';
					config.group = options.group || 0;
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