### Планировщик задач
##### FullUpdateTask (ДО и ПОСЛЕ рынка)
Запускается при ручном добавлении нового тикера и после закрытия рынка (1 раз)
* IndexListRequest
  * IndexListUpdatedEvent  
  _- формируем уникальный список компаний из индекса и БД_  
  _- для каждой компании запускаем:_
    * CompanyRequest
      * CompanyWithoutLogoEvent
        * DownloadCompanyLogo (если нет логотипа)
      * CompanyUpdatedEvent
        * QuoteRequest
        * PerformanceRequest
        * RoasterRequest
        * TransactionsRequest
        * all other Entity update, where has companyId in Entity

##### Realtime - цепочка (каждую минуту 24 часа, пока открыт рынок)
1. IsMarketOpen (триггер для старта MassQuoteRequest)

##### Realtime - цепочка (каждые 10 минут, пока открыт рынок)
1. MassQuotesRequest

#### NewCompanyAddedEvent (manual)
Если добавлена новая компания, которой нет в БД. Запускаем:
* DownloadCompanyLogo
* PerformanceRequest
* QuoteRequest
* RoasterRequest
* TransactionsRequest

#### IndexListUpdatedEvent (daily)
* CompanyRequest
* DownloadCompanyLogo
* PerformanceRequest
* QuoteRequest
* RoasterRequest
* TransactionsRequest
