<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - Customer</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-container { width: 100%; margin: 0 auto; padding: 20px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header img { max-width: 150px; }
        .section { display: flex; justify-content: space-between; }
        .section div { width: 48%; }
        .section table { width: 100%; }
        .details-table, .items-table { width: 100%; border-collapse: collapse; }
        .details-table td { padding: 4px; }
        .items-table th, .items-table td { border: 1px solid #000; padding: 8px; text-align: center; }
        .items-table th { background-color: #f0f0f0; }
        .total { font-weight: bold; }
        .text-word { text-align: center; margin-top: 20px; font-size: 12px; }
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 12px;
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
        }

        .footer b {
            font-weight: bold;
            color: #1a73e8;
        }

        .footer .note {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 5px;
        }

        /* Print-Specific Styles */
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .footer {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                page-break-after: always;
            }
        }
    </style>
    
</head>
<body>
    <div class="invoice-container">
        <div class="header">
			<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJIAAABuCAYAAADMK0rsAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsMAAA7DAcdvqGQAACbUSURBVHhe7Z13nBXFssffPw/YwJKRqMSVnFEv+ZJURBSQtOQgSJIkwUBSLwoqioiIAUQEl6gI14QEAwhyTfjEAAoC6tWrJEWy/epbffqcs4fZXdZ7zhKc+nzqMzM93dU13b+pru7p6f4f45NPUSAfSD5FhXwg+RQV8oHkU1TIB5JPUSEfSD5FhXwg+RQV8oHkU1TIB5JPUSEfSD5FhS5KIJ0+fVr51KlTwhxPmxMnTpojR343b731tlm16p/mnnv+YSZPuse0vbGdadHiatOwYROTXL6SiYvLbeJyhTg+PtHkyhWvHBeXYPLlLWDKli1vmjVrYVq2vMbc0KatueuuCWby5HvMihUrzLp168xvv/0WyPuUOXnyZJguli9G8oHkAykqdNECiQr8+OOPzVNPPm26pnQzl15aSoCRoIDInTuPSUjIbQoXKqLgUJDkSjQN6jcxCfF50gCpSpVqej8hXkAVJ6DKGW9q1aqj6QkHaMgAXLly5ZJzABdn6tSpa/r27WcWPr/Q/PDDv82xY8fNqZM+kM47Smt1TgXOT4tVeNHcfHN/c9llpbWSAQAVXaLEpXrUihdAcWzevKWCA1aQ5bRgyiWgckC6USwWgHFMvI4dOyugYAekRo2a6DFnzjgFWdGixfVa0wi4ateqa8aNvd28++4msY4ngro70HO8kOmCBNIff/yhhU9FcFy/fr3p16+fyZevkFibfHrMl7eQAsNZodKly5qaNWoHKx7wAIhSl5XR+xZMuU3fPv2DIIJHjRqtMhz4iDt82IggIJF17TWtTMEChYNpyPe6VjeIzKRgWLw0mQULFDGJCXnFepU1d9xxh/n000/N0aNHFUQ804VMFySQKPjvv//e3H///aZSpUpiBXJKhcYFgJNbK6ve3xrJtW2OYKwHoAAIWAyAkJQ7rxk9emygmQJcSWbRwsUmZw6AYwHw3HMLrGWR9Bxp6lKkqVTgyTVgmjhxsrV8gTQ1a9Q1VavUVHkurFLFaqZM6WQNy52b/ONV76ZNm5q5c+f6FinWdPr0H+b48RPmpDjLOMxHfz9mJkyYZH0ZecupmEqVqpkSxUtp5TqglC1T3rRv18GCIBCGc0wTlJiYpE0Q8Rc8t1CPam0ELKteXh0EDbxkyVKN7yxb167dFUjuft68+c3ChS8EfSjkDBlyq9VF5JAGn+zmfv2DchMSrB9W5JISeuQZypZNNtOmPmAOHTosVhZLe0qf90KhCwBI+BC2UB966GF1mvPkyW+BFKgEzltfd6NWGBVIZVGBw6QJSi5fIQgCwleuXKWVDbAIf/rpuaZatRrB+y+ueEmaxgJ6Di9ZssxUrFjZgkR43rxnTZs2NwbvjxwxyvTs0UtlAs5LLilq7rzjLpWXM4eAVcLHj58YlMk1L0DjRs2kWS2noMICYhHRh+eb8o/7pMk7Ji/PheOYn1dAcr6CO8L4QUuXLjPly18eqATpIYm1KV2qvILINR3w0KG3agUSj7ef4/PPL7LnAWsxSZqhjh066zVxO3dOUcA5IC1btsK0b9/BypAw8r7uuuu1kuGtWz8w5ctdHoy/YcPbaYA2beqD4rA3skCV++3a3WRGCNhUd0mP5epwUxdzzdWtJSykP+F1614ZlJssz/vMM7bJc2Xh+Hyk8wpIrgeGA338+HHzzTffSM+qhUlKyqtve6jJSTSNGzczTRo3l2aHe1Sybc5mzpyllUFzxLF//1vMpEmTg+nppn/99Tcqh8rFgrxMc0YFSkUDnLvvvtc2fXJ/3boNJqWLNGUBENAzJC3xa9SoZX788Se9B5crl2x27vxG45Ee8K9du07lEMZzNGnS1Iy/a5LqiyVCf3y6jh27BMGn6cWa8QyNGjUyu3fv1p4eZUL5nI903gGJAjt27JiZMWOGFCRWIc4ULlzElBMfwoLIMo51xw4ppkvn7nJt32oKnu76vHnzg01XYkKSWJF/CfD+bnLkyKXXa954U60Q9wHE7l3farNI5d8jIHrppZUSbu/hk+EXAcLWrduoz0Y64k6Zcp9ZvHipVjw6PT5rtrn33imaDvCsXv2KDjGgC2GXX17RLBQL6fw7AFS82GVm8KBbRXdplrFaAEni8yx1614h13GmZMmS5o033tAX7Hx1ys85kKwP5Lryp8yeb/eZVq0CTYk2P/ZtpyK6d++h3XgK3PayErVpGjxoqMalErg345FHzdixtwebs8biYO/atVuc22Iah9HsfXv3mTxJ+fT6DQHWLbcM0rg9xN/BHwMc5IlevXr1kvNcZtzYcebXX3/VcCp7z569Zqg41oCqevWa2ikALMgZN+4OBSzxYCzhls3vq5VKFL8ol1hRHOylS5bLi1JUgarPJcfateuavzdpFsjHPVeC9Dpv004Hg5voeD41c+cFkLBC8Ib1b0vzlCwFmKg+EEcdHJSCdIyjy+cJCt1VUrduPcz8+QukQqVJE4tDZbz//lbTTSwJ94m7fPmLWmncg/ft/c5MECcYwNx//zSzbu16PadHhtWpVLGKViT6jR49WmTEi4zl5t133xWAJqgOp06eNvXqNdA831yzzrz++hrNr3KlKgoqnHiuS5UqY3bs2Km+F3nzHHXqXCHN3vrgi5FbLBIWc8CAW8xNN3W04Am8CHD+fAVNXulkkN/ePfv0pUPP84XOOZB4q7BIixcvlgIL9cLwe666qoEU+JVBEDlLMHToMNOnd1+9doBijCg1dbHtHYm1wlnl00SXLl218ipXrqpvce9efTTNP6QJomdEJffq2Vt9H5xmLBwV1EWOVCQWad68eaJPTvPzzz9LL26J5rtIuvyk55whBWQDQq5fenGlmfnoY5pPkSLFzLZtnwpYp+o1z0G8L7/8Sq0U1oww/Lv5858THapomIvLsWHDxurgO2DRzH/wwUc+kCDAgxXieO+99woY7BuI7+C69taBTtZeD00GgKGiKODevfsI+JaYkiUuC4Y/Ik3aB//60CQnV9AC79SpiwKkkziyyH7kkRnm4MHDOiRQrWoNyfu0+GKPmr/9rb5WChaqRvVaCornFyw0ZcqUU4sEeEqVKqWgWrp0qSlYsJA5cfykfvwl382bt2gzhx700g4f/lUByvUrr7xm3nlno9VbAE7TuXPH1woidCQOFvWVV15N0zMF/FgfBkwLFbxEw/CbsJqkyZMnn1jIFWoVKcdzTecMSFQKPGjQIHWqrVNZSsdWnPNsOVGbjjFjxqkjmz9/QS1ICrZd25vMxx9/Yq6//oZgATMS/c03uwO+SJKZJQ4wfk3DBo1MsWIlzPff/2A++XibVtjaN9cp0AAMfscOqWD8JoD08UefmBtuaKs6AqSUlBQ9f+GFF8zAgYP0BeCrP59ZiD916gMKjj3S7Dz55NOqS2rqErNv33cKbIAxZ86T5ttv94hFKa/6Y61okhdLPJo2gII1ormjue1wU6cgsHgRAOMl4k8xup4kenKPcS7yP9eUrUBy4LHN2SkzfLj0nPRrOU0XnwziTYECl4gz3EGczeZS+ITbAqRiKonv8fprb5j28tY7M395ckV1pB8NNCVauNKT+v67H7SXxTVNC81cBbFq48bdrjpMm/ag6dmzlwKC4YG3335HK4RmBN1gfCzivvTSSwKOJ9U6DR48WPyv9zVd27btzVdf7VCLULVqNfPqq6+pjJo1ays4SNtJgIajvGzZcrNXHPzkZNtEMQywS3qL99831b4YYq14GSZOmKzWMNipkDIhPi8GvUeaelyABHlJEuKT9JyxL1eu4Q74aXlJsLT/+c9/1HrxQZvnigVlO5Bcc/bknGekkBgNxvfBxNueDIXHW1mmdDnteTEOBJBg91ZidebMeUo/uAJCLApf1T/55FNTtUp1DcO5plJTUrqaChUqqH/DeAwfTL/66ivz+++/i8W5QQD2g1iJb8306dNVr+eee06HH9D1qaee0jAc7LVr12rYhAkTNIznGDZsmI7tbNiwQQA6TsNffPFFM3LkSA1nCKNMmTJm48aN5pdffjENGjSQ54s39913v1pAprc4oODzffjhx+JsDww+r1ot6WnSAwyNnstLJU1/+GAs5wwPuLJ1hMPPuFiB/IWCMgEk43NwNOmcACk1NdUWgLxRhQoWFUeyojrWvGW2228BRSHXr99QfaE7br9TrBVf9K2vwaeJA/sPavNCk0Aa4h0/dkIdb95ywESeVDJNE3kDmoEDB+r5rl27zKJFi7TwAQNhhw8fFkf4Sw3bsmWLpqdpdLrv2LFDQfL222+LhdmrYQ8//LCCj/A2bdqY/fv3m61bt0qlldcKA7StWrUy5cqVEyf5Ax23YjIdOmIBN8pLwMDl5TSBUtm8SPiEDz44PfDClNZnpkzUCglw8ucrLL5dQ3PZpWK55Lp06dLm66+/Vj0d/f77UbGa7Uwv6WA0a9rCVK9W07Ro3tJcffXVytGkbAUSlbNz505TqFAhBRK+EIXACG/RoiWlSWtvbr55gDRBlbTQ1AIJcChcuv18npg27QFzqfhSFCyFvWXL+zpSrYOGEg8/im9UdMUrVKgk3fI3Nd+FCxdq74uCZvrGtm3bFATbt2/XJuvgwYN6pGkgjjt3R3fu7kGEMQ0EsJAHLwhARVb37t3Nd999p3Hbt29vhgwZonF5fnpd+E1z5z6rVgPgM5LNM111VT0Nx0HnnIFSXhKeDeC1a9dBmtye4og3lrIRCyVlRxli6apVqxbUjyMj9qRNfWGJ9l7Hjb3DbNr4nsjKpRxNynaLVKNGDXm4OHGE82pBACbXxAEcAEQXnR7WrbcO11FtV5AcKfTP/m+7WqLixUpqONNcj4kl4s2+6sp62pwxG/G77743A/oP0JmSFO7KlSu1ecNyOGuCToDAgSOrRDrHWDNkvfnmm+bIkSOaD83cyy+/rHmRf4kSJXT0/MiRo9KUfWQqV6qqAGratLlZv26DWMMdOmsB0LihAeZRPfzwDH3OShWrmhw5eLmwTraJg3UajYCjf//+Clj0oCNCeb6wKFWHHB6e/og0109Lr7OgcjQpW4E0fvx4KSCarjht0qpXry1+QxNbENrW2x6aA06jhk20W4yTSEFQuDAW6801a81vvx3RAuaaD57bt38uwDithUV8nFkKdM2aNTp/iYplPjVhDkAcHf8ZcpYKBizwgQMHVPbzzz+vForzBQsWmD59+mjzg++G5aSSaXa2bNmqvclRI29TC0w4E+UGDx5i1q/foD4V04JxxnUEP+Ab8fIxz7x6tdrq+2HpAdNrr72mz4pjfe211wXLU3u2InvixInK0aSYA8kV7ueff64PGWSxQmqRciXJG9hZrNDNZujg4aZG9boBYDlONJUrVzYzZ87UCsIBrlWrlgKyZcuW4mB/ov4J3XI+cOI0kx9+DXHxg6hkCja2RG8JMALKE+bnX34SkJ1S3Z599ln1t9ALH6tevXpmzJgx2swBsgceeECa9qICoHjToUMHddj37Nmjjr0LdxaHY6dOncyIESPU76NsuA9QnNWmyafJJG/KjLhFihQxFStWNA899JCGw9GkmAOJgoLpwXTt2jWMuwWZUWSONEmrV63Wwb3n5i8w3bp1D8Tpajp37qxjTjiryHvnnXe0gAhnqq0Dy6ZNm7SrzjkVd+jQIbU23I8tASTywDrxzFiEE9pbcy8TvhSzOukp8gw0r+4ZZs+erT1LdOV5COO5u3TpoudYcxx8OgLIcOHuGCzLLilynaKzFrDOlANNHXLRwZULHE2KOZBcs0HBpa1MW+i8tbzBFP4pOHCu18Fz23REyuJIgXCMDHfxOdL8cP7fULjDHX4NQy4fdx6uE0enC+x0joznwmDCiOeu3T0X1507VhwLM3ZE00mzdkKsEjLQizgujZMZTco2IPEmhBf+H39Q8GfLNk14QbijqwjHrpKiTeTPM4Tn6fTgGl9oy+Yt4livMiuWrzDvvbdZwvaoPuH6Oc6qnsR1+YbKMJzRERALaPSzCfECibOBYg4kChvm58GaNWuG8RVnyXWEQ+nwg/AjMPs9evRQn4hPGPgUtPsUNvlFmxyA8HEYRiDvhg0bqn8CJybyvS9BelR2LrhOcxHH1t5LNPXr1ze9e/fWcSscf2dtzpYAEE50eFmk5dohll7ehg1vXZxAwuG0DiE9COGcdPsj2VbAmUy4ZZxv/XSi53bIgCO9Hb513TZqtE4hwT/AzLs3loo4WwIwpEFvfbOlvufNnW8aNmisA4K252T1cPnrCL12HmyPClZ9A3HtfKmA7uIQt2lzg46BWYBaK5MRcX/ZsmUiE6c7vGwCHOi86JCBlPMrr7ySqcxoUjYCab4WYHhBn8m2kNMwYZ5xz2SGBkgDYJkRyUyA48dwerNmpQAd1g2rsWnTFv1LReUHZiVEAibrbL+rcezZo7fZ/8sB0S9zIDEfCpB4y7Rse25x5tVXXw2kzB66QIAUyd4VyduoVo/RcD6lSPonZj+hgMjK24m+pGE0HPDAuRPzZQIg7p2dnuilzZ5YKI58eGYUPCPygZRFIFEQ2lw4IClTODSLmG076cuZ8jSVmyZNKO3UqVPVKp0tEXfVqlWSX66Q7HTYDabSvORJ4sfM+mLBKmu+9lnsyHNmejZp8nd15tPT0wdSFoBEZQCS0beN0WkXIV6mzKAjjjXjJUlJ+c8KSM4ZzkrB/vjjj/qB9WyAxCeeQQOHmi8+/1KbRBhrxofahx6abi4pXFya3NBEPZvmTD2Zm81gIWm9yAdSViwSE9rEGjGfiJbIcqiLSyU5eQf2HzDjx/PHrR399m5arIWj8CtXrhKUwdGL3H0G/7AozCPy1FPYARgnnO42sy3Ry+loZZ02H3247UyLFNQ3xDlz5jJVqlTR9F6EPB9Iwmdlkei5SaEuW7oikNqbTp9m7AZn+LjO9cbJ5nceL5khTtDxHVfRkURFOSAwc9FbhmVAATiuvLKeDvqRxgucONAnT5w23bv1DjaB6bE212IBv/jii0DqtOQDKQZAkmIVEDFmZAf1mNtju9neci0nmBtvtFNnvSrdAYkv99aKecmwnDOHBRI/YwIW94yRhEymtCxamCrxSXumJXKs1k8AwJxwL/KBFAMgIY9PK1gmgMFosm3KvOVa5n68OrSkiSQqivBp06ZpPG8Zju0cqrc2vBNMC0eSjjJL88YsRX32DNkCAB/Qi3wgxQBIUqzCgMHKZiYgI8peMkOM452g869JE0lUFNaND8f8t+YtwzIWCT35ppUROZlMtQ19rPZmvuTDTOv1Ih9I2QAkmo9atep6ygwxo9AJ5rHHHksXSFiktm3b2srwlBFixpYyWy3EPTtyOZJHeuzi+b22dMgVZnSBFCJXCbzVXjJDbJsPpsCSJpIIoyILF7b/kHnLsMx4Fj0s8s0u8oGUDUACAN26sWKIt1zLfI+K0/k76QEAWQx42u9VXjIs00QyucwLkLEiH0jZACTk33bbbZ4yQ2yB1KJFC08AEAbr6HmmFomV27qmC8hYkA+kbAISn0G8ZIaYwck4naabEZCohMz0pDJ9IKWliwZITzzxhKfMEEve4iNdfvnlPpBiQBcFkOhi85Oil8wQ214bk+V9IEWfLhqLdPvtt3vKDLEF0lVXXeUDKQZ0wQPJye/bt6+nzBBbH6ljx47pAgk5iYEV0rxlWAaQDB4SPyNyujmQZsQuXnoyuecDSTjWQOKXHC+ZIZa8MwCAk3PFFYGVZT1lWOZLPd1/LznhROXT7LrPMg40Xsz99D7fQMTxgSQcayA1a9bMU2aIAVK8LihBpUSSq8zOnbtkCiQqs1ixYgqSjAi9kMm03dWrV+s86vSYimcyHf/teZEPpBgDiYriP//MK98Cia/r6BNJVBThWKzM9LRf7BMk78wtEjIBnJ3diVybNpKZ1McMBtZT8iIfSDEGEh9OWUjUVoi3XMv2o+2+ffs8mw9nkR5/fHbmI9uBiWpf79wVSO1NTiac+bMDMLvaiBf5QIoxkJiqwRLFmVuRBJ1LTaXii0QSFYXlYMGqzGWhZ24zf/7zgdTehEyY9QmYuOYlxzHPDkC7dO4aSJ2WfCBFEUgUJrL4DwxAnD71hy7GrnLTkR0fl0crnWbj3nv/oV/XvXwbZCOTe7r+tujBdBEvmc56tL6ujYIyI5n8d89iFpk1vW7W5dAhwwKp05IPpCgCycmyVuWELiTFssHOz0hPJsek3PnM3j17tcJJH0lUlN4TkPbrF9izLd3psTac9Rv/ufqfCiSv6R9O14oV7cJhZ8oJsQPSa6+tCaROSz6QsgQkO2GMhdWl3M5gLBFLEc+c+ZipV6+hFDyVg+9D+rSysULWl+FjbYKZNOnuYMWmBySnK+ssRa5FlEZ2AJw5c9B7K6kb57i/ZcPlsNBXxw6dtHKtrmnloJ9OklMLl6iLbiHHi3wgBQr1bIDE9FWO/IwYeQ+mwPk12uteONsmKWBNpKfGekTpTRjzIoB25513aoVEyvZi1sIEBIx2T548Wdc1YpwpT568et8CxTstesbH0/zGq3/mBXLIB1IWgGQtSKLJ8b8ZF1b6bN9sa6HkPI6tq67QBSayCiR8Gx0KCMg8k0P56gsgFocuPszouF0Ui269bbLSgikgQ/TjpwB2SJo163HVkbLyIh9IWQASTIFT8F73HEe+4a6imG+UGPb//5jRY/V3IafD2VJ489T/5gEqyzFL5wGOSIBoE0olBuJZHWhWcdpDz63PpzJsPJY6ZAfKzHTMKpAY5MxOOu+AlFW2ALLrdLN8DItssv41Sw1iWTKqnLMhemX8olSnTh0BAJXP37cOPGkBnRkriAR8Tg7f/VjzGyc/Mz19IMUYSGw5wZ5t/HX7+uuva/MAgGDOqYD/htyqJDwDf3gA0sqB1UmyAiQXl4VDx44daz777DMFELI5ZqbnXx5IvNEwK5rhTGbMa9LhUBzWV3QLk8MUcHYzoGItbRYNZacAwKVrOKZ0V2bHSda15temAQMG6MJcgIA1Ih1ossoADl+PxbbCyyOSuY9/xDqV7gUgz1hTzIHEwzg+u4rn7Qvn0D3XBHB+rkAEOxCjC+yu3TqOLl7kffjPAol0pHfPnx67/IgPOzDFmmIOpLvvvkeZt5O1r9l/Iz3mfoq+yXIdWKWVa7ahIowVW/VNJ6yr3TY9mC4dxkKwymuaPP5LRgenhwtj54FuXXtoXsG4Gs/mzfOzem94mqww+ZGHHuU6PbblbJkhDAe+WFPMgXR1y2uV6eWEus7pcHCAMdSrIYyxI1YdcSuP6PJ5crS7BeAbRMgJZ7mPI667CQm7tNFi/WovR/RgcS+7KLroJP6gHc0+d8zWYs5SxZqyAUitlN1ocEbMXq+sfp/6wuLg2kiMcg8dMkKd1JCMJLM4dbmZ8chjmcqllzRi+GiJv8w0atg0EJ7x8ELWWGRJHiVLlNKNd9ijjWV5xt81Ufeq9U6TPXyRAom3xPuBgyzWB/DwRZ9FQB3zazS9JyadYVUYlzl69Lh0nXfq2+/m8vAWqoXCiuXgswRy2Ytjsa5hRDPHYKVaDyxfIC5xADHnLlzHgJSxivbcvunIdECUa7nH9hVs8IeeBw8cMvv3HxC9T5pvd+8x5fgWKHKRzxZZmoeOOQXyCZxjOZ21dEe7ExI6YuUC1pTr8DLLgC9OIAUrISNmE+MV8uBGfQ27uGiiad+uo+4hcvz4Ud04jw1x2EPfVrAd1GOrLW0SpbL4rkUY6ZNy23jcI4y5RoS77dmLFy+pGx0TRhxtjiQ+1wCE7bHsqm8WcFZPByS2B82tK/oDnJ49e6s+gBurynezOU88GdQTGXVqX6G7QLHNg90ejCba6sQ1+rZq1dpuPwqIhdl1m+242GWS+GnLLH32gSTPjVOpE8x4UyWcZf/YlmHYsOEaxtf/L774SiuIbba4Tk6uoGCh4nbu/Fo3vSlatLhZtChVK7pzJ7u37VK275T4jz/+hFY2FpD47NpIZbHM8v99yjiPnbvErkc4yl5Aat36eu0dbdy4ScHgAMlmhOwSCajIs2KFygK4XarH8eN2ZX62vGIzZ+IcOHDQHPntd90Clf1yZ8+eY4oXK6FjY+hAHnu+3WM6sAN3mjJLn30gyXPTUwEQ7g0cNWqkOXnqhFmyZKlUTJLGoWmjMllzEiDxhZ+K5I1mGuxjM2dpJbJfmcrsYnfBZh9Y4gOokiUv092UiN+jO/v7J+j2V1zTW2QtSfY9IX7VKjXE4oXrm6A9S2hZYA0kC370DrDEIc+R4vtt3/6F7juXL28B3U8XUKETwKNJZNNCno9nr1+/gW41RvedXZVq1qwhL8xO89OPP5m8eQqG6ZA++0CKABI+0dixY8RynBTLlKqyHJBoygoWLGwOHTqslomKZBCTN75WrToi0258Fw4kAIQ/w563QeCJD3XLLYNM0SLFdW1ufB7b7e4iFfqIVnr//gMDeoYskgOSLqYl165p5NyBCZ1otrB4WNrHZ81Wa8rEPHQi7v79B3WdJ+K4dGzIw8p0KSmdTdduKWbt2jUKrI4dUkQmPpbTw5svMiC57j+FC5gcez182qbNzuGRN1oKjbUiT506aQYNGqLxHJAocMDBCrI0V+xACYjeeusdrVSAdgaQli7XCWxstkwlt2x5jVogZNM8AhqAtEziARCsBJ2Anj37aN7qAOszJJhrrrnW/CFN4/bPttumTZ3/eNOkcVO1fOyXhh7jx09Q8L63abOZ+ehjusoceTL2w30cdK7DAWi3xDgueS+R3uALclwqMpeYpn9voSAK/xjsxRcZkK5RpnBdASl7PHg4kGhWiEfl3DJgoL6thw4eVv8FcDggATZklyuXLACQXtPBg1ohN97YzjYzUjFBIEmlkXb5MsnjtDEVK1bWtAAJP2nw4KGahmYGn6VkictUh8ECMPbfd3v1hz8H+rE0MqvaPjDtIU3PtvD/+tcHqs+UKfdpnKNH2fP2ZPDlYFdHfCFeGHQ4LBYVHYNyBZD4XTy3zgKVsEkTJ+tUXLel/V/MIv05IOGTYDWoICwE61YzKqzdd6lM4mjTJnJhKgtLwyjul19+ZXLk4Cs9+Zw9kAYOHKwV3bdPP7VqOOBYJXTZvftb7eFRwWmfI0EBtuub3WJB2A+Nz0H28wQbHqMXOrPNKPfefXejWb/+LfPzz7+IhTqp03rR6eDBQ6ojMh1Yr7vuepW1Y8dOs27dej3H0trhAOl1/rUskmvapMKlwFzlej0491l5lkHJESNGSQ9thBkgfgnjP7Y7jF9gC3nE8JHihPaTwozTdHCVytU0XcsW11hLFQi/vvUNKpOmjLRtrr9B47FfLnrhl+AMs6sQeRDWuHETM0t8GfbvJy+7ZDLNbPgzhK7p7aHPggXPm2eemaf70rp76IiVmigWJTV1sfpiWJnh8nzXiy5YMaweOgEi1TtQXtWr19TdthcvXqrNNqBkTM5NSfEqR8cNGjRUQF8Un0hYuhimYKhELSBlmqS0rBUTKMDw+ByVA/c5p/C1osJkAh7XnLmwYPzA9ldOlu5qHUhLeGSTpXFEFhYFDlZuBky+Lq3Txd1z+qqFQg/3LBx5jsA191wad8+dW524PrPsvLiBWCT3ETfWFHMg3TflfmWai969+4a4181nMG809/r07qfxuXZH5WDaPoHrfrq5cEimDQ8Ps+lFphz79iUf4thw7iOTe3oeiEv68PiaJiAvXe6VVo6T4e6jq4vHMZS/PYbyCsjjnsRxMtLE9yg7L5486W61SHCsKeZA8umvQT6QfIoKxRxIrtcQq54DPgCys8OhdOSeJzzvP/N84XIudIo5kHD04AYNGkgXdl0gNHpERTDFdPDgwYGQ2FP4DEQWgOd4/PiZ6wlkRj/99JOWiyujC5myDUh8QWfPtWgTnwwY9WbZ4+wiByQ+JBcpUkR1+DNWhRkNzPlG1oVulWIOJAoI5s8GJsBHEvd2795t3nvvPbN9+3bz9NNPGzZSZqJ7ZAFTgVxz3LBhg5k1a5aCk88G6QGJyuK+S0ulb9myxWzatEnluyaJo8sPC4elmT9/vurk0joiHvqxtnfevHn1uQhz5HRkZ3F+VGARiZUrVwbDHR05csSkpqZ6PqcD50cffWRmz56t26JiwQiDnd6OSMMzzZkzR382eP/991VupOxYUbb5SOkBiXuAga/sV155pXnwwQdNy5Yt9U0HYOEVRGFxTZyyZcuaGTNmmFtvvdWUL18+XSDx90pCAoti2cqB+ZrOX7ThlgQ9+LY1cuRI3VodEE2aNMnw/xlf/8MrA1kffvihadeunUlKSjJjxoxJoydxuSZt7dq1DcsSDh06VNPBjtjHlnJBj/Bw0qILH4tLly6tR/5UoYwoE+TD4WBieejk5GQ9TpkyReMC4Mg8Y0XnHEgUCBYjX758aj0oRLhAgQK6ulp4IRAXX4R9QNh/n8Lm/ogRI9IFEgtrASTSOdksXMp/+py7yuCILAA8ffp0PScN1mnrVrZ/D+nBObqgHz9kIodrR1wDDp6Zbbu4Zz/Aph3TQTfihOsBkS8vAD98btu2TWURxv9wgNLlH54nzzN69GiNB2OxndUlfazpvLBIhN90001pCqZatWpaUeEFzDkFQ3PiKgXGoqUHpL1796plIJ4r/H79+qlF8pK9YMEC9edKlSplevbsqf4XFRNZGcghX4BE2nDduYbJl+YtPXJACtcDQhYvF/fQE5CwKEXjxo0V6AAJXcPTsf5k8eLFTeHChTX+3Llzza+//qp6/2WARIUw7ye8YLyARIFQiADJVS4FmpGzTfORM2fOIIhgAOIFJFfoLCCBzFGjRmnTwjGyMpATSyDx7FhSAAXjI+HcE45+kfpQHpQFP0eyGkqFChV0FRbiEh5rOi+AROHwFoUXaNWqVbWiwsMoELhmzZpiut+Sc9r/06ZXr97iV10diJWWaC7Jm9ViSYs8fKBIIFF5VA75hjcJ+Cf4bOFAgQA0etMkcy9cFucwQOKZ3XUkAXLiRN5H9r///W99AdioEF0ACn4SzbjLLzxNx46ddN0oygS9+TgMEF2ZxZpiDiQKBU4PSBQKPRe2yQqvLCqUiiKtI+5TSPgtefPmFzB004n7zEVq3rxlIFZaYvoJIMU5Jw9AiPXD1wgvYGRzzZbpWCHuw1g/LEK4bu6ZNm/erM+F041P44i43MfH4Zm59gISFok4PFO4fAccygUwoG/z5s3VgaYX6EXMDmC+uv5E2jlFJ+jNnDnz4gGST38N8oHkU1TIB5JPUSEfSD5FhXwg+RQV8oHkU1TIB5JPUSEfSD5FhXwg+RQV8oHkU1TIB5JPUSEfSD5FhXwg+RQFMub/ARb26QJr914QAAAAAElFTkSuQmCC" alt="Logo" height="150">
            <h3><u>CUSTOMER COPY</u></h3>
        </div>
		
		<hr style="color: blue;">
		<div class="section" style="padding-left: 10px;color: blue;">
            <table>
                <td>    
                    <p><strong>ORDER NO:</strong> {{ $order->order_number }}</p>
                </td>
                <td style="text-align: right;">
                    <p><strong>ORDER DATE:</strong> {{ $order->order_date }}</p>
                </td>
            </table>
        </div>

		<div class="section" style="text-align: left;background-color: #e8f5e9; border: 1px solid #000;width:100%;">
            <table>
                <td width="50%">
                    <h4 style="margin-top: 4px;">Customer Details:</h4>
                    <table class="details-table" style="margin-left: 8px;">
                        <tr><td>Name:</td><td>{{ $customer->name }}</td></tr>
                        <tr><td>Mobile No:</td><td>{{ $customer->mobile_number }}</td></tr>
                        <tr><td>Organization Name:</td><td>{{ $customer->organization }}</td></tr>
                    </table>
                </td>
                <td width="50%" style="margin-top: -15px;border-left: 1px solid #000;padding-left:5px;">
                    <h4 style="margin-top: 4px;">Delivery Details:</h4>
                    <table class="details-table" style="margin-left: 8px;margin-top: -14px;">
                        <tr><td>Address:</td><td>{{ $customer->address }}</td></tr>
                        <tr><td>City:</td><td>{{ $customer->city->city_name }}</td></tr>
                        <tr><td width="40%">Delivery Date:</td><td width="60%">{{ $order->delivery_date }}</td></tr>
                    </table>
                </td>    
            </table>    
        </div>
        <br/>
        <table class="items-table">
            <tr>
                <th>S.No</th><th>Particular</th><th>Net Amount</th><th>Qty</th><th>Total Amount</th>
            </tr>
            @foreach($order->items as $index => $item)
                <tr>  
                    <td style="vertical-align: top;">{{ $index + 1 }}</td>
                    <td style="text-align: left;">
                        {{ $item->product->name }}
                        <div style="padding: 0px !important;padding-left: 13px !important;margin-top: -9px !important;}">
                            @php $label = 'A'; @endphp
                            @if($item->shade) <br/>{{ $label++ }}. Shades: {{ $item->shade->name ?? 'NA' }} @endif    
                            @if($item->size) <br/>{{ $label++ }}. Size: {{ $item->size->name ?? 'NA' }} @endif  
                            @if($item->pattern) <br/>{{ $label++ }}. Pattern: {{ $item->pattern->name ?? 'NA' }} @endif  
                            @if($item->embroidery) <br/>{{ $label++ }}. Embroidery: {{ $item->embroidery->embroidery_name ?? 'NA' }} @endif  
                        </div>
                    </td>
                    <td style="vertical-align: top; align-items: center;">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAw0lEQVR4nO2TPQ6BQRCGHzqtiBv4KURUnEFB4gYi4SjCEVQadxAkRNxAIQqln4S4gYRmJNt84tvd2YYnmWKa95nszMIfBwbA88va2Qj2MQR9PJABOsBdQhdAAgWqwEMkDZegOjCKqKsIttIPbQTzGDuY2AjaQC+iDhK8lL6ER2rGDpo+g7NA17iiFZB0Cfz05msg7Trx0QjcyN2PgZbr5G9ywEkEMyCFAvkQkgJwDiG5aEuKISRl4KYtqRifbaoh4Ld4Ac6qW7tGznjjAAAAAElFTkSuQmCC" 
                            alt="Rupee" height="15" style="display: inline-block; vertical-align: middle;">
                        
                        <span style="display: inline-block; vertical-align: middle;">
                            {{ number_format($item->price, 2) }}
                        </span>
                    </td>
                    <td style="vertical-align: top;">{{ $item->quantity }}</td>
                    <td style="vertical-align: top;align-items: center;">
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAw0lEQVR4nO2TPQ6BQRCGHzqtiBv4KURUnEFB4gYi4SjCEVQadxAkRNxAIQqln4S4gYRmJNt84tvd2YYnmWKa95nszMIfBwbA88va2Qj2MQR9PJABOsBdQhdAAgWqwEMkDZegOjCKqKsIttIPbQTzGDuY2AjaQC+iDhK8lL6ER2rGDpo+g7NA17iiFZB0Cfz05msg7Trx0QjcyN2PgZbr5G9ywEkEMyCFAvkQkgJwDiG5aEuKISRl4KYtqRifbaoh4Ld4Ac6qW7tGznjjAAAAAElFTkSuQmCC" alt="Rupee" height="15" style="display: inline-block; vertical-align: middle;"> 
                        
                        <span style="display: inline-block; vertical-align: middle;">
                            {{ number_format($item->total_charges, 2) }}
                        </span>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="total">Delivery Charges</td>
                <td style="vertical-align: top; align-items: center;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAw0lEQVR4nO2TPQ6BQRCGHzqtiBv4KURUnEFB4gYi4SjCEVQadxAkRNxAIQqln4S4gYRmJNt84tvd2YYnmWKa95nszMIfBwbA88va2Qj2MQR9PJABOsBdQhdAAgWqwEMkDZegOjCKqKsIttIPbQTzGDuY2AjaQC+iDhK8lL6ER2rGDpo+g7NA17iiFZB0Cfz05msg7Trx0QjcyN2PgZbr5G9ywEkEMyCFAvkQkgJwDiG5aEuKISRl4KYtqRifbaoh4Ld4Ac6qW7tGznjjAAAAAElFTkSuQmCC" alt="Rupee" height="15" style="display: inline-block; vertical-align: middle;">

                     <span style="display: inline-block; vertical-align: middle;">
                        {{number_format($order->delivery_charge, 2) }}  
                    </span>
                </td>   
            </tr>
            <tr>
                <td colspan="4" class="total">Discount</td>
                <td style="vertical-align: top; align-items: center;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAw0lEQVR4nO2TPQ6BQRCGHzqtiBv4KURUnEFB4gYi4SjCEVQadxAkRNxAIQqln4S4gYRmJNt84tvd2YYnmWKa95nszMIfBwbA88va2Qj2MQR9PJABOsBdQhdAAgWqwEMkDZegOjCKqKsIttIPbQTzGDuY2AjaQC+iDhK8lL6ER2rGDpo+g7NA17iiFZB0Cfz05msg7Trx0QjcyN2PgZbr5G9ywEkEMyCFAvkQkgJwDiG5aEuKISRl4KYtqRifbaoh4Ld4Ac6qW7tGznjjAAAAAElFTkSuQmCC" alt="Rupee" height="15" style="display: inline-block; vertical-align: middle;">

                     <span style="display: inline-block; vertical-align: middle;">
                        {{number_format($order->discount, 2) }}  
                    </span>
                </td>   
            </tr>
            <tr>
                <td colspan="4" class="total">Payable Amount</td>
                <td style="vertical-align: top; align-items: center;">
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAw0lEQVR4nO2TPQ6BQRCGHzqtiBv4KURUnEFB4gYi4SjCEVQadxAkRNxAIQqln4S4gYRmJNt84tvd2YYnmWKa95nszMIfBwbA88va2Qj2MQR9PJABOsBdQhdAAgWqwEMkDZegOjCKqKsIttIPbQTzGDuY2AjaQC+iDhK8lL6ER2rGDpo+g7NA17iiFZB0Cfz05msg7Trx0QjcyN2PgZbr5G9ywEkEMyCFAvkQkgJwDiG5aEuKISRl4KYtqRifbaoh4Ld4Ac6qW7tGznjjAAAAAElFTkSuQmCC" alt="Rupee" height="15" style="display: inline-block; vertical-align: middle;">

                     <span style="display: inline-block; vertical-align: middle;">
                        {{number_format($order->payable_amount, 2) }}  
                    </span>
                </td>   
            </tr>
            <tr>
                <td colspan="4" class="total"><b>TOTAL AMOUNT PAYABLE </b></td>
                <td style="vertical-align: top; align-items: center;"> 
                    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAw0lEQVR4nO2TPQ6BQRCGHzqtiBv4KURUnEFB4gYi4SjCEVQadxAkRNxAIQqln4S4gYRmJNt84tvd2YYnmWKa95nszMIfBwbA88va2Qj2MQR9PJABOsBdQhdAAgWqwEMkDZegOjCKqKsIttIPbQTzGDuY2AjaQC+iDhK8lL6ER2rGDpo+g7NA17iiFZB0Cfz05msg7Trx0QjcyN2PgZbr5G9ywEkEMyCFAvkQkgJwDiG5aEuKISRl4KYtqRifbaoh4Ld4Ac6qW7tGznjjAAAAAElFTkSuQmCC" alt="Rupee" height="15" style="display: inline-block; vertical-align: middle;">
                   
                    <span style="display: inline-block; vertical-align: middle;">
                        <b> {{ number_format($order->total_amount, 2) }}</b>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="5"> 
                    <div class="text-word">
                        <p><b>In Words: {{ $amount_in_words . ' Rupees Only'}}</b></p>
                        <p>(This is System generated copy no sign and seal required)</p>
                    </div>
                </td> 
            </tr>
        </table>

        <div class="footer" style="color:blue;">
            <p><b>Payment details: 9826150305 (Gpay/Paytm/phonepe)</b></p>
            
            <p><b>NOTE:</b> 1. Alteration & Modification charges may Apply. 2. For any other collection and delivery charges may
apply. 3. Any Manufacturing defects. Please call us on 1234567890 or mail us to mail@mail.com</p>
        </div>
    </div>
</body>
</html>

