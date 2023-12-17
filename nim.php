
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css.php">
    <meta name="theme-color" content="#191919">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#191919">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#191919">
    <title>Folio.wtf</title>
</head>

<body class="hero-anime">
    <header>

        <div class="header">
            <nav>
                <div class="navbar">&nbsp;</div>
            </nav>
        </div>

    </header>


    <div class="navigation-wrap bg-light start-header start-style">
        <div class="container">
            <div class="row cifix">
                <div class="col-12">
                    <nav class="navbar navbar-expand-md navbar-light">

                        <a class="navbar-brand" href="/" target="_blank"><img class="mainlogo" src="logo.png"></a>

                        <div class="col-120">
                            <div id="switch">
                                <div id="circle"></div>
                            </div>
                        </div>

                    </nav>
                </div>
            </div>
        </div>
    </div>



    <div id="app">
        <router-view></router-view>
    </div>

    <div class="ads">ADS GOES HERE</div>
    <div class="footer">Copyright 2023 - All Rights Reserved.</div>

    <template id="new">
        <div class="content">

            <button @click="showaddmodalfn()" id="nextBtn" type="submit" value="" class="plus"><span class="subadd"><img class="arrow" src="arrowic.png">ADD COIN</span><span class="plusfix">+</span></button>


            <div class="portbox">
                <div class="pftitle">Your Folio</div>
                <div class="pftotal">${{safefloat(total_value)}}</div>
                <div class="pfwatch">Watching {{tickers.length}} Coins</div>
                <div class="pfchange">
                    <b v-if="total_value < total_value_buy" class="red">{{folio}}%</b>
                    <b v-else class="green">+{{folio}}%</b>
                </div>
            </div>

            <button @click="clear()" style="top: 20%;
    position: absolute;
    left: 10px;
    background: none;
    outline: none;
    border: 1px solid #ccc;
    color: #ccc;
    padding: 5px;
    border-radius: 3px;">delete all</button>
            <!--<button @click="showaddmodalfn()" id="nextBtn" type="submit" value="" class="plus"><span class="subadd"><img class="arrow" src="arrowic.png">ADD COIN</span><span class="plusfix">+</span></button>-->
            <!-- The Modal -->
            <div class="modal modalfix" v-if="showaddmodal">
                <!-- Modal content -->
                <div class="modal-content modalfix1">
                    <span @click="hideaddmodalfn()" class="close2">&times;</span>
                    <div>
                        <div class="tickersearch">
                            <p class="modaltext">Search btc, eth , bnb , etc</p>
                            <input placeholder="Search btc, eth , bnb , etc" v-model="q" type="text" class="ticker">
                        </div>
                        <div class="results scroll custom-scrollbar">

                            <div class="result" v-if="search_results.length > 0">

                                <div class="sub" v-for="item in search_results" :key="">
                                    <img v-bind:src="'https://s3-symbol-logo.tradingview.com/' + item.logo+'.svg'"><span @click="addticker(item.exchange+':'+item.symbol)" class="subleft">{{safeticker(item.symbol)}}</span>
                                    <!--<span class="subright"><a @click="addticker(item)" href="#" class="add">add</a></span> -->
                                </div>

                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showholdmodal" class="modal">
            <!-- Modal content -->
            <div class="modal-content">
                <span @click="hideholdmodalfn()" class="close">&times;</span>
                <p class="modaltext">Please enter units of {{safeticker(selected_ticker)}} and its buy price</p>
                <p class="center">
                    <input v-model="amt" type="text" class="mobbase" placeholder="Number of coins">
                    <input v-model="qty" type="text" class="mobholding" placeholder="Price paid per coin">

                    <button @click="add_holdingnew(selected_ticker,qty,amt)" type="submit" value="" class="btn mobbtn pcview-2 btnfix">ADD</button>
                </p>
            </div>
        </div>
        <div class="boxfix" v-if="tickers.length > 0">

            <div class="box bold top topbox">
                <!--<div class="topspfix"><span class="rmv"></span>&nbsp;</div>-->
                <div class="item top btnrmv">&nbsp;</div>
                <div class="item top item1">WATCHLIST</div>
                <!--<div class="space top">&nbsp;</div>-->
                <div class="item bold top item2">PRICE</div>
                <div class="item bold top item3">HOLDING</div>
                <div class="item bold top item4">FOLIO</div>
                <div class="item top btnrmv">&nbsp;</div>
                <!--<div class="spacer spacertop"><span class="rmv">&nbsp;</span></div>-->
            </div>



            <div class="box" v-for="tick in tickers" :key="">
                <div style="width:100%;">
                    <button @click="removeticker(tick.ticker)" class="btnrmv" href="#">
                        <div class="spacer"><span class="rmv">X</span></div>
                    </button>

                    <div class="item item1 tokfix">
                        <span class="tokenlogo"><img :src="`https://s3-symbol-logo.tradingview.com/${tick.logo}.svg`" class="coinlogo"></span>
                        <span class="name">{{safeticker(tick.ticker)}}</span>
                    </div>

                    <div class="item item2">
                        <span class="price">${{tick.lp}}</span>
                        <span v-if="tick.chp < 0" class="changes red">{{safefloat(tick.chp)}}%</span>
                        <span v-else class="changes green">+{{safefloat(tick.chp)}}%</span>
                    </div>
                    <div class="item item3 item3fix">

                        <div style="text-align:center;">
                            <div class="prcfix"><span class="percent">{{calc_percentage(tick.total,total_value)}}%</span></div>
                            <div class="barfix">
                                <div class="bar barprc" :style="{ width: calc_percentage(tick.total,total_value) + '%' }">
                                </div>
                            </div>
                        </div>
                        <!--</div>-->

                        <!-- <div class="rowbtn"><button v-else @click="showholdmodalfn(tick.ticker)" id="myBtn" type="submit" value="" class="btn">ADD</button></div> -->
                        <!-- The Modal -->
                    </div>

                    <div class="item item4">
                        <span class="price">${{safefloat(tick.total)}}</span>
                        <span v-if="tick.total < tick.btotal" class="changes red">{{safefloat(tick.total-tick.btotal)}}</span>
                        <span v-else class="changes green">+{{safefloat(tick.total-tick.btotal)}}</span>
                    </div>


                    <!--    <div class="item item4 digit4">
                        {{calc_percentage(tick.total,total_value)}}%
                    </div>
-->


                    <button v-if="isExpanded(tick.ticker)" @click="toggleExpansion(tick.ticker)" type="button" class="item collapsiblenx btnrmv rmvfixx">-</button>
                    <button v-else @click="toggleExpansion(tick.ticker)" type="button" class="item collapsiblenx btnrmv rmvfixx">+</button>



                    <div v-show="isExpanded(tick.ticker)" class="">

                        <div class="modal-content modfix">

                            <p class="modaltext unitfix">Please enter units of {{safeticker(tick.ticker)}} and its buy price</p>
                            <p class="center">
                                <input v-model="amt" type="text" class="mobbase" placeholder="Number of coins">
                                <input v-model="qty" type="text" class="mobholding" placeholder="Price paid per coin">

                                <button @click="add_holdingnew(tick.ticker,qty,amt)" type="submit" value="" class="btn mobbtn pcview-2 btnfix">ADD</button>
                            </p>
                        </div>
                        <div class="headuseritems">
                            <div class="headuseritem1">Unit</div>
                            <div class="headuseritem2">Price</div>
                            <div class="headuseritem3">Buy Value</div>
                            <div class="headuseritem3">Current Value</div>
                            <div class="headdel"> Delete </div>
                        </div>

                        <div class="" v-for="hold in tick.holdings" :key="">

                            <div class="headuseritems entfix">
                                <div class="headuseritem1">{{ hold.unit }}</div>
                                <div class="headuseritem2">{{ hold.unit_price}}</div>
                                <div class="headuseritem3">{{ safefloat(hold.unit_price*hold.unit)}}</div>
                                <div class="headuseritem3">{{ safefloat(tick.lp*hold.unit)}}</div>
                                <div class="headdel"><button @click="deleteonehold(tick.id)" class="entdel"> delete </button></div>
                            </div>

                            <!--<div class="useritems">
                                    <div class="useritem1">Amount: {{ tick.unit_price}}</div>
                                    <div class="useritem2">Unit: {{ tick.unit }}</div>
                                    <button @click="deleteonehold(tick.id)" class="entdel"> delete </button>
                                </div>-->

                        </div>
                        <!--<em><span class="tnx">You can add hold using above option</span></em>-->
                    </div>


                </div>



            </div>



        </div>





        </div>



        <div class="calbox">
            <div class="calc">
                <p class="pinp">Percentage Calculator</p>
                <div class="calibox">
                    FROM
                    <input v-model="from_price" type="text" class="frominp">
                    TO
                    <input v-model="to_price" type="text" class="frominp">
                </div>
                <button type="submit" class="calx">Calculate</button>
                <input type="text" class="disinp" v-model="percentage_price" value="" disabled>
            </div>
            <div class="shareitwide"><button @click="print" class="shareitwide">Share it!</button></div>
            <div class="boxtot">
                <div class="tabsinp">
                    <div class="days">

                        <span v-for="dur in durations" :key="" class="in-days" :class="{ 'green' : duration_selected === dur }" @click="update_emoji(dur)">{{ dur }}</span>



                    </div>
                </div>

                <div id="share" class="emoji">
                    <div class="pixel">
                        <span class="emtext">Your folio.wtf is on <b class="orange">Fire</b> by</span>
                        <div class="prctext">
                            <b v-if="folio <= 0" class="red">{{folio}}%</b>
                            <b v-else class="green">+{{folio}}%</b>
                        </div>


                        <div class="emj"><img :src="`/img/pepebobo/${filename}`" class="emojiax"></div>
                        <div class="shareit"><button @click="print" class="shareit">Share it!</button></div>
                    </div>
                </div>
            </div>
        </div>


    </template>

    <template id="home">
        <h1>Home</h1>
        <button @click="clear()">delete all</button>
        <input placeholder=" search btc, eth , bnb , etc" type="text" v-model="q">
        <p>{{ q }}</p>

        <div v-if="matched.length > 0">
            <p>matched ticker {{ matched.length }}</p>
            <div class="content" v-for="item in matched" :key="">
                <p> {{safeticker(item)}} <button @click="addticker(item)">add</button></p>
            </div>

        </div>

        <div v-if="tickers.length > 0">
            <div class="menu">{{ tickers.length }} TICKERS WATCHING</div>
            <div class="content" v-for="tick in tickers" :key="">
                <p> {{safeticker(tick.ticker)}} {{tick.lp}} <button @click="removeticker(tick.ticker)">remove</button>
                </p>

                <div v-if="tick.unit">
                    <div> holding : {{tick.unit}} {{safeticker(tick.ticker)}} </div>
                    <div> value: ${{safefloat(tick.unit*tick.lp)}}</div>
                </div>
                <div v-else><button @click="addholding(tick.ticker)">add holding</button></div>

            </div>

        </div>
    </template>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.global.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/vue-router/dist/vue-router.global.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/dexie"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/axios@next"></script>



    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <script type="text/javascript">
        window.addEventListener("load", function(event) {



            const plugin = {
                install: (app, options) => {
                    console.log('plugin', app);

                }
            };



            const Ws = {
                name: 'home',

                template: "#new",
                watch: {
                    q: {
                        async handler(newValue, oldValue) {

                            let q = newValue.toUpperCase()

                            console.log(q, oldValue);
                            if (q) {
                                try {
                                    await this.search_tv(q);
                                } catch (e) {
                                    console.log(e.response.data)
                                }


                                let match = []
                                for (const [ticker, value] of Object.entries(this.config)) {

                                    //console.log("this", ticker)
                                    if (ticker.indexOf(q) >= 0) {
                                        match.push(value)

                                    }

                                }
                                this.matched = match;
                                console.log(match);
                            } else {
                                this.matched = []
                            }

                            //console.log(this.config)

                        },
                        deep: true
                    },
                    from_price: {
                        handler(newValue, oldValue) {
                            this.update_percentage();
                        }

                    },
                    to_price: {
                        handler(newValue, oldValue) {
                            this.update_percentage();
                        }

                    },
                    folio: {
                        handler(newValue, oldValue) {
                            this.get_image_by_pc(newValue);
                        }

                    }


                },
                provide() {
                    return {

                        is_connected: Vue.computed(() => this.is_connected),
                        ws_msg: Vue.computed(() => this.ws_msg),
                        config: Vue.computed(() => this.config),
                    }
                },
                data() {
                    return {
                        total_value_buy: 0,
                        total_value: 0,
                        holdings: [],
                        expandedGroup: [],
                        showaddmodal: false,
                        showholdmodal: false,
                        ws: null,
                        ws_msg: null,
                        notify: false,
                        db: null,
                        timer: null,
                        ping_interval: 5000,
                        mails: [],
                        tickers: [],
                        selected_ticker: null,
                        config: null,
                        is_connected: false,
                        q: null,
                        matched: [],
                        folio: null,
                        ws_url: 'wss://wss.checker.in:8443',
                        from_price: null,
                        to_price: null,
                        percentage_price: null,
                        durations: ['NOW', '24H', '1W', '1M', '3M', '6M', '1Y', ],
                        duration_selected: 'NOW',
                        filename: '0.png',
                        search_results: []

                    }
                },
                created() {

                    this.db = new Dexie('crypto');
                    //this.db.delete();
                    //console.log(this.db);

                    // Declare tables, IDs and indexes
                    this.db.version(2).stores({
                        tickers: '&ticker, unit, unit_price,buy_price, lp, ch, chp, lp_time ',
                        holdings: '++id, *ticker, unit, unit_price',
                    });
                    this.db.open();

                    /*
                    this.db.tickers.limit(50).toArray().then((rows) => {
                        this.tickers = rows;
                    });
                    this.db.holdings.limit(50).toArray().then((rows) => {
                        this.holdings = rows;
                    });
                    */

                },
                methods: {
                    async search_tv(ticker) {
                        this.search_results = []
                        //let results = await axios.get("https://symbol-search.tradingview.com/symbol_search/v3/?text="+ticker+"&hl=0&exchange=&lang=en&search_type=crypto_spot&domain=production&sort_by_country=US")
                        let results = await axios.get("/tickerSearch.php?ticker=" + ticker)
                        //console.log(results.data.symbols);
                        for (let r of results.data.symbols) {
                            try {
                                if (r.currency_code == 'USDT') {
                                    this.search_results.push({
                                        exchange: r.exchange,
                                        symbol: r.symbol,
                                        ticker: r.symbol.replace('USDT', ''),
                                        logo: r['base-currency-logoid']
                                    })

                                    //console.log(this.search_results)
                                }
                            } catch (e) {
                                console.log(e)
                            }
                        }


                    },
                    get_image_by_pc(p) {
                        let filename;

                        if (p <= -90) {
                            filename = '-90.png'
                        } else if (p <= -80 && p >= -89.99) {
                            filename = '-80.png'
                        } else if (p <= -70 && p >= -79.99) {
                            filename = '-70.png'
                        } else if (p <= -60 && p >= -69.99) {
                            filename = '-60.png'
                        } else if (p <= -50 && p >= -59.99) {
                            filename = '-50.png'
                        } else if (p <= -40 && p >= -49.99) {
                            filename = '-40.png'
                        } else if (p <= -30 && p >= -39.99) {
                            filename = '-30.png'
                        } else if (p <= -20 && p >= -29.99) {
                            filename = '-20.png'
                        } else if (p <= -10 && p > -19.99) {
                            filename = '-10.png'
                        } else if (p <= -5 && p > -9.99) {
                            filename = '00.png'
                        } else if (p <= 4.99 && p >= -4.99) {
                            filename = '0.png'
                        } else if (p <= 19.99 && p >= 5) {
                            filename = '20.png'
                        } else if (p <= 39.99 && p >= 20) {
                            filename = '40.png'
                        } else if (p <= 59.99 && p >= 40) {
                            filename = '60.png'
                        } else if (p <= 79.99 && p >= 60) {
                            filename = '80.png'
                        } else if (p <= 99.99 && p >= 80) {
                            filename = '100.png'
                        } else if (p <= 149.99 && p >= 100) {
                            filename = '150.png'
                        } else if (p <= 199.99 && p >= 150) {
                            filename = '200.png'
                        } else if (p <= 299.99 && p >= 200) {
                            filename = '300.png'
                        } else if (p <= 499.99 && p >= 300) {
                            filename = '400.png'
                        } else if (p <= 999.99 && p >= 500) {
                            filename = '500.png'
                        } else if (p >= 1000) {
                            filename = '1000.png'
                        }
                        this.filename = filename;

                        return filename;


                    },
                    async print(event) {
                        console.log(event);
                        html2canvas(document.getElementById('share'), {
                            allowTaint: true,
                            useCORS: true,
                            backgroundColor: null,
                            removeContainer: true
                        }).then(function(canvas) {
                            var link = document.createElement("a");
                            link.download = "folio_wtf.png";

                            canvas.toBlob(function(blob) {
                                link.href = URL.createObjectURL(blob);
                                console.log(blob);
                                console.log(link.href); // this line should be here

                                link.click();
                            }, 'image/png', 100);


                        });





                    },
                    connect() {
                        console.log("yes connecting", Date.now())
                        this.ws = new WebSocket(this.ws_url);
                        this.ws.onopen = this.onconnected;
                        this.ws.onmessage = this.onmessage;
                        this.ws.onclose = this.onclose;
                    },
                    onconnected(event) {
                        this.is_connected = true;
                        this.timer = setInterval(() => {
                            this.ws.send('ping');

                        }, this.ping_interval);
                        console.log('connected');
                    },
                    onmessage(data) {
                        this.ws_msg = data.data;
                        try {
                            let m = JSON.parse(this.ws_msg)

                            if (m.type == 'init') {
                                this.config = m.tickers;
                                this.update();
                            } else if (m.type == 'update') {
                                this.update_watch(m.ticker, m.update)
                            } else if (m.type == 'info') {
                                this.update_watch2(m.tickers)
                            } else {
                                console.log('unexpected type', m.type)
                            }

                        } catch (e) {
                            console.log("unexpected response")

                        }

                    },
                    onclose() {
                        console.log("closed/failed");
                        this.is_connected = false;
                        this.ws = null;
                        clearInterval(this.timer);
                        setTimeout(this.connect, this.connect_interval);

                    },
                    clear_storage() {
                        localStorage.clear();
                        this.$router.go();
                    },

                    async update_fire_emoji() {
                        let buy = 0;
                        let total = 0;



                        for (let j of this.holdings) {

                            let cp = this.get_current_price(j.ticker);

                            buy += j.unit * j.unit_price;
                            total += j.unit * cp;

                        }
                        let percent = (total - buy) / buy * 100;
                        this.folio = percent.toFixed(2);

                    },
                    async update_fire_emoji_with_selected() {
                        let buy = 0;
                        let total = 0;




                        for (let j of this.holdings) {

                            let it = this.get_current_price_new(j.ticker);

                            //buy  += j.unit * j.unit_price;
                            if (this.duration_selected == '24H') {
                                buy += (j.unit * it.lp) * ((100 - it.chp) / 100);
                                console.log("bu", it.chp)

                            } else {
                                buy += j.unit * j.unit_price;
                            }
                            console.log("buy", buy, it, j)

                            total += j.unit * it.lp;

                        }
                        let percent = (total - buy) / buy * 100;
                        this.folio = percent.toFixed(2);
                        this.get_image_by_pc(this.folio);
                        console.log(this.duration_selected, this.folio)

                    },

                    async update_emoji(selected) {

                        this.duration_selected = selected;
                        console.log(this.duration_selected, selected)

                        /*
                        this.db.tickers.limit(50).toArray().then(async (rows) => {
                            this.tickers = rows;
                            let payload = [];
                            for (let [a, b] of rows.entries()) {
                                console.log(a, b)
                                payload.push(b.ticker);
                            }
                            this.update_fire_emoji_with_selected();
                            //let pers = await axios.post("/percentage.php", payload);
                            //this.update_with_selected(selected, pers.data);



                        });
                        */


                    },
                    async update_percentage() {
                        let diff = this.to_price - this.from_price;

                        if (this.from_price && this.to_price) {


                            this.percentage_price = (diff > 0 ? '+' : '') + ((diff / this.from_price) * 100) + '%';

                            console.log(diff, this.percentage_price);
                        } else {

                            this.percentage_price = null;

                        }

                    },
                    async update_watch(ticker, update) {

                        //console.log(ticker, update)
                        update.ticker = ticker;
                        if ('lp' in update) {

                            let check = await this.db.tickers.get({
                                ticker: ticker
                            });
                            if (check) {

                                //console.log(check)
                                this.db.transaction("rw", this.db.tickers, async function() {

                                    this.db.tickers.where({
                                        ticker: ticker
                                    }).modify(update);

                                })


                                //await this.db.tickers.put(update, ticker);

                            } else {

                            }

                            //await this.db.tickers.put(update, ticker);
                        }

                        /*
                           
                           */



                    },
                    async fix_update(ticker, data) {
                        let update = {
                            chp: data[5],
                            lp: data[4],
                            ticker: ticker,
                            logo: data[2],

                            w1: data[6],
                            m1: data[7],
                            m3: data[8],
                            m6: data[9],
                            y1: data[11],

                        }
                        let check = await this.db.tickers.get({
                            ticker: ticker
                        });
                        if (check) {

                            //console.log(check)
                            this.db.transaction("rw", this.db.tickers, async function() {

                                this.db.tickers.where({
                                    ticker: ticker
                                }).modify(update);

                            })


                            //await this.db.tickers.put(update, ticker);

                        } else {

                        }

                        return;

                    },
                    async update_watch2(update) {
                        //console.log(update)
                        for (const [key, value] of Object.entries(update)) {
                            let d = this.fix_update(key, value);

                            //console.log(`${key}: ${value}`);
                        }



                        return;



                    },
                    handler(e) {
                        console.log(e)
                    },
                    safeticker(ticker) {
                        let i = ticker.indexOf(":");
                        return ticker.substr(i + 1).replace('CRYPTO:', '').replace('USDT', '').replace('USD', '');

                    },

                    safefloat(float) {

                        return new Intl.NumberFormat('en-US').format(parseFloat(float).toFixed(2))

                    },
                    async add_holdingnew(ticker, amt, qty) {
                        if (amt && qty) {
                            console.log(this.db.holdings)
                            this.db.transaction('rw', this.db.holdings, function() {
                                // Let's add some data to db:
                                insert_object = {
                                    ticker: ticker,
                                    unit: qty,
                                    unit_price: amt
                                };
                                this.db.holdings.add(insert_object);


                            }).catch(function(err) {
                                console.error(err);
                            });

                        }
                        this.hideholdmodalfn();
                    },
                    async addholdingnew(ticker, amt, qty) {


                        if (amt && qty) {
                            console.log(amt, qty, ticker);

                            this.db.transaction("rw", this.db.tickers, async function() {


                                let tick = await this.db.tickers.where("ticker").equalsIgnoreCase(ticker).toArray();


                                this.db.tickers.where({
                                    ticker: ticker
                                }).modify({
                                    unit: qty,
                                    unit_price: amt,
                                    buy_price: tick[0].lp

                                });

                            })
                        }
                        this.hideholdmodalfn();


                    },
                    async addholding(ticker) {
                        let unit = prompt("How much " + this.safeticker(ticker) + " are you holding?");
                        if (unit) {
                            console.log(unit);

                            this.db.transaction("rw", this.db.tickers, async function() {

                                this.db.tickers.where({
                                    ticker: ticker
                                }).modify({
                                    unit: unit
                                });

                            })
                        }


                    },
                    async addticker(ticker) {

                        console.log("add", ticker)
                        this.showaddmodal = false;

                        try {
                            this.db.transaction("rw", this.db.tickers, async function() {


                                let check = await this.db.tickers.get({
                                    ticker: ticker
                                });
                                if (check) {
                                    console.log(ticker, "exist")
                                    //await this.db.tickers.update(ticker,update);
                                    //await this.db.tickers.put(update,ticker);
                                } else {
                                    //alert("adding",ticker)

                                    console.log("not exist")
                                    await this.db.tickers.put({
                                        ticker: ticker
                                    }, ticker);

                                }
                            })
                        } catch (e) {
                            alert(e.message)
                        }


                    },
                    async removeticker(ticker) {
                        console.log("remove ", ticker)
                        this.db.transaction("rw", this.db.holdings, async function() {
                            await this.db.holdings.where('ticker').equals(ticker).delete();
                        })


                        let check = await this.db.tickers.get({
                            ticker: ticker
                        });
                        if (check) {
                            console.log(ticker, "exist")
                            await this.db.tickers.delete(ticker);
                            //await this.db.tickers.put(update,ticker);
                        } else {
                            console.log("not exist")
                            // await this.db.tickers.put({ticker: ticker},ticker);

                        }


                    },
                    update_with_selected(selected, percentages) {


                        console.log("update_with_selected")

                        this.db.tickers.limit(50).toArray().then((rows) => {
                            this.tickers = rows;

                            console.log("inside rows", typeof this.durations, selected)
                            console.log("index", this.durations[0])

                            let index = 0;
                            this.durations.forEach((i, o) => {

                                if (i == selected) {
                                    index = o;
                                }

                            })


                            console.log("index", index);




                            let old_total = 0;
                            let new_total = 0;

                            for (const i of this.tickers) {
                                console.log(i, percentages.data, "hmm")
                                for (let d of percentages.data) {
                                    console.log(d)

                                    if (i.unit && d.s === i.ticker) {

                                        old_total += (i.unit * i.unit_price);
                                        new_total += (i.unit * i.lp * d.d[index]);

                                    }
                                }

                            }
                            let diff = new_total - old_total;
                            this.folio = this.safefloat((diff / old_total) * 100);
                            console.log("folio", diff, old_total, new_total, this.folio)




                        });




                    },
                    async update() {
                        setInterval(async () => {

                                console.log("updating...")
                                this.holdings = await this.get_all_holdings();
                                this.tickers = await this.get_all_tickers();

                                let hold = this.holdings
                                let tick = this.tickers
                                let ototal = 0;
                                let obtotal = 0;

                                let duration_selected = this.duration_selected;



                                tick.forEach(function(value, i) {

                                    let h = [];
                                    let total = 0;
                                    let btotal = 0;


                                    for (let hh of hold) {

                                        if (hh.ticker == value.ticker) {
                                            h.push(hh);


                                            /*


                                            if (duration_selected == '24H') {
                                                total += hh.unit * 100 * (value.lp / (100 + value.chp));
                                                ototal += hh.unit * 100 * (value.lp / (100 + value.chp));

                                            } else if (duration_selected == '1W') {
                                                total += hh.unit * 100 * (value.lp / (100 + value.w1));
                                                ototal += hh.unit * 100 * (value.lp / (100 + value.w1));

                                            } else if (duration_selected == '1M') {
                                                total += hh.unit * 100 * (value.lp / (100 + value.m1));
                                                ototal += hh.unit * 100 * (value.lp / (100 + value.m1));

                                            } else if (duration_selected == '3M') {
                                                total += hh.unit * 100 * (value.lp / (100 + value.m3));
                                                ototal += hh.unit * 100 * (value.lp / (100 + value.m3));

                                            } else if (duration_selected == '6M') {
                                                total += hh.unit * 100 * (value.lp / (100 + value.m6));
                                                ototal += hh.unit * 100 * (value.lp / (100 + value.m6));

                                            } else if (duration_selected == '1Y') {
                                                total += hh.unit * 100 * (value.lp / (100 + value.y1));
                                                ototal += hh.unit * 100 * (value.lp / (100 + value.y1));

                                            } else {
                                                total += hh.unit * value.lp;
                                            ototal += hh.unit * value.lp;
                                                
                                            }
                                            */

                                            if (duration_selected == '24H') {
                                                value.lp = 100 * (value.lp / (100 + value.chp));

                                            } else if (duration_selected == '1W') {

                                                value.lp = 100 * (value.lp / (100 + value.w1));

                                            } else if (duration_selected == '1M') {

                                                value.lp = 100 * (value.lp / (100 + value.m1));

                                            } else if (duration_selected == '3M') {

                                                value.lp = 100 * (value.lp / (100 + value.m3));

                                            } else if (duration_selected == '6M') {

                                                value.lp = 100 * (value.lp / (100 + value.m6));

                                            } else if (duration_selected == '1Y') {

                                                value.lp = 100 * (value.lp / (100 + value.y1));

                                            } else {


                                            }


                                            total += hh.unit * value.lp;
                                            ototal += hh.unit * value.lp;




                                            btotal += hh.unit * hh.unit_price;
                                            obtotal += hh.unit * hh.unit_price;


                                        }
                                    }
                                    tick[i].holdings = h;
                                    tick[i].total = total;
                                    tick[i].btotal = btotal;


                                });

                                this.tickers = tick;

                                this.total_value = ototal;
                                this.total_value_buy = obtotal;

                                this.folio = this.calc_percentage(this.total_value, this.total_value_buy) - 100;
                                this.folio = this.safefloat(this.folio);

                                for (let t of this.tickers) {
                                    console.log(t, ototal)
                                }





                                let p = {
                                    type: 'info',
                                    tickers: []
                                }
                                for (let t of this.tickers) {
                                    p.tickers.push(t.ticker);

                                }

                                console.log(p)

                                this.ws.send(JSON.stringify(p))


                            },
                            2000);
                    },
                    clear() {
                        this.db.tickers.clear();
                        this.db.holdings.clear();
                        alert("cleared")

                    },
                    showaddmodalfn() {
                        this.showaddmodal = true;
                    },
                    hideaddmodalfn() {
                        console.log("hmm");
                        this.showaddmodal = false;

                    },
                    showholdmodalfn(ticker) {
                        console.log(ticker)
                        this.selected_ticker = ticker;
                        this.showholdmodal = true;
                    },
                    hideholdmodalfn() {
                        console.log("hmm")
                        this.showholdmodal = false;
                        this.selected_ticker = null;

                    },
                    get_current_price(ticker) {
                        for (let i of this.tickers) {
                            if (i.ticker == ticker) {
                                return i.lp;
                            }
                        }


                    },
                    get_current_price_new(ticker) {
                        for (let i of this.tickers) {
                            if (i.ticker == ticker) {
                                return i;
                            }
                        }


                    },
                    calc_percentage(value1, value2) {
                        let percentage = value1 / value2 * 100;
                        return percentage.toFixed(2);

                    },

                    isExpanded(key) {
                        console.log(key)
                        //alert(key)
                        return this.expandedGroup.indexOf(key) !== -1;
                    },
                    async toggleExpansion(key) {

                        console.log(key);
                        if (this.isExpanded(key)) {
                            this.expandedGroup.splice(this.expandedGroup.indexOf(key), 1);
                        } else {


                            this.expandedGroup.push(key);
                        }
                    },
                    async get_all_holdings() {
                        return new Promise((resolve, reject) => {

                            this.db.holdings.limit(50).toArray().then((rows) => {
                                console.log("holdings loaded", rows)
                                resolve(rows);

                            }).catch(e => {
                                reject(e)
                            })


                        });
                    },
                    async get_all_tickers() {
                        return new Promise((resolve, reject) => {

                            this.db.tickers.limit(50).toArray().then((rows) => {
                                console.log("tickers loaded", rows)
                                resolve(rows);

                            }).catch(e => {
                                reject(e)
                            })


                        });
                    },
                    async deleteonehold(id) {
                        console.log(id)
                        await this.db.holdings.where('id').equals(id).delete();
                        //this.syncholdings()
                    }


                }


            };

            const Main = {}

            const routes = [{
                    path: '/',
                    props: true,
                    component: Ws
                },

            ]

            const router = VueRouter.createRouter({
                history: VueRouter.createWebHashHistory(),
                routes
            });

            app = Vue.createApp(Ws);
            app.use(router);
            root = app.mount('#app');


            if (navigator.onLine) {
                console.log("hm")
                root.connect();
            }




            window.addEventListener('offline', function(e) {
                console.log('offline');
                //root.onclose();

            });

            window.addEventListener('online', function(e) {
                console.log('online');
                //root.connect();
            });




        }, {
            once: true
        });
    </script>



    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
    <!--
    <script>
        (function($) {
            "use strict";

            $(function() {
                var header = $(".start-style");
                $(window).scroll(function() {
                    var scroll = $(window).scrollTop();

                    if (scroll >= 10) {
                        header.removeClass('').addClass("col-122");
                        header.removeClass('start-style').addClass("scroll-on");
                        $('.container > .row > .col-12 > nav > .col-120').addClass('switchon');

                    } else {
                        header.removeClass("scroll-on").addClass('start-style');
                        $('.container > .row > .col-12 > nav > .col-120').removeClass('switchon');
                    }
                });
            });

            //Animation

            $(document).ready(function() {

                $('body.hero-anime').removeClass('hero-anime');

                var coll = document.getElementsByClassName("collapsible");
                var i;

                for (i = 0; i < coll.length; i++) {
                    coll[i].addEventListener("click", function() {
                        this.classList.toggle("active");
                        var content = this.nextElementSibling;
                        if (content.style.maxHeight) {
                            content.style.maxHeight = null;
                        } else {
                            content.style.maxHeight = content.scrollHeight + "px";
                        }
                    });
                }


            });

            //Switch light/dark

            $("#switch").on('click', function() {
                if ($("body").hasClass("dark")) {
                    $("body").removeClass("dark");
                    $("#switch").removeClass("switched");
                    document.documentElement.setAttribute('data-theme', 'light');
                } else {
                    $("body").addClass("dark");
                    $("#switch").addClass("switched");
                    document.documentElement.setAttribute('data-theme', 'dark');
                }
            });

        })(jQuery);
    </script>
    -->





</body>

</html>
