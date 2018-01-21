Simply **Gearman**. Client and Worker example.

Build docker:
```
docker-compose build
```
Up docker:
```
docker-compose up
```

Open two console and attach to php container in each console:
```
docker exec -i -t turbo_php_1 bash
```

In first console run:
```
cd /var/www/turbo
php app.php processor=worker
```
In second console run:
```
cd /var/www/turbo
php app.php processor=client
```

Each time when you run client, client will send to worker data.
In console with worker you can see how data processed.

**Example:**
```
Input: Привет, мне на <a href=\"test@test.ru\">test@test.ru</a> пришло приглашение встретиться, попить кофе с <strong>10%</strong> содержанием молока за <i>$5</i>, пойдем вместе!
Process by method: stripTags
{ text: Привет, мне на test@test.ru пришло приглашение встретиться, попить кофе с 10% содержанием молока за $5, пойдем вместе! }
Process by method: removeSpaces
{ text: Привет,мненаtest@test.ruпришлоприглашениевстретиться,попитькофес10%содержаниеммолоказа$5,пойдемвместе! }
Process by method: replaceSpacesToEol
{ text: Привет,мненаtest@test.ruпришлоприглашениевстретиться,попитькофес10%содержаниеммолоказа$5,пойдемвместе! }
Process by method: htmlspecialchars
{ text: Привет,мненаtest@test.ruпришлоприглашениевстретиться,попитькофес10%содержаниеммолоказа$5,пойдемвместе! }
Process by method: removeSymbols
{ text: Приветмненаtesttestruпришлоприглашениевстретитьсяпопитькофес10содержаниеммолоказа5пойдемвместе }
Process by method: toNumber
{ text: 10 }
```

**TODO**

Need to send data like a parameter to client. Because now data hardcoded in app.php file.
Also need run worked with supervisor.
    


