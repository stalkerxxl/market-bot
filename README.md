### Планировщик задач
##### Main - цепочка (daily)
Запускается при ручном добавлении нового тикера и после закрытия рынка (1 раз)
1. CompanyRequest
2. DownloadCompanyLogo (если нет логотипа)
3. PerformanceRequest
4. QuoteRequest
5. RoasterRequest
6. TransactionsRequest (не мало ли - раз в день??)

##### Realtime - цепочка (каждую минуту 24 часа, пока открыт рынок)
1. IsMarketOpen (триггер для старта MassQuoteRequest)

##### Realtime - цепочка (каждые 5 минут, пока открыт рынок)
1. MassQuotesRequest