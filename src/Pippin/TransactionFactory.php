<?php

namespace Pippin;

class TransactionFactory {

    /**
     * @return Transaction[] An array of Transaction objects.
     */
    static function transactionsFromIPNData(array $IPNData) {
        if (array_key_exists('transaction[0].id', $IPNData)) {
            return self::transactionsFromAdapativePaymentsIPN($IPNData);
        }
        else {
            return self::transactionFromExpressCheckoutIPN($IPNData);
        }

        return [];
    }

    /**
     * @param array $IPNData
     * @return Transaction[]
     */
    private static function transactionsFromAdapativePaymentsIPN(array $IPNData): array {
        $transactions = [];

        for($i = 0; isset($IPNData["transaction[{$i}].id"]); $i++) {
            $prefix = "transaction[{$i}].";

            // For Adapative Payments IPNs, the amount has the form "<CURRENCY> <AMOUNT>"
			// For example, "USD 5.00". Split the string by spaces to get the various components.
            $amount = explode(' ', $IPNData[$prefix . 'amount']);

            $transactions[] = new Transaction(
                $IPNData[$prefix . 'id'],
                $IPNData[$prefix . 'status'],
                $IPNData[$prefix . 'receiver'],
                $amount[0],
                $amount[1]
            );
        }
        
        return $transactions;
    }

    /**
     * @param array $IPNData
     * @return Transaction[]
     */
    private static function transactionFromExpressCheckoutIPN(array $IPNData): array {
        return [
            new Transaction(
                $IPNData['txn_id'],
                $IPNData['payment_status'],
                array_key_exists('business', $IPNData) ? $IPNData['business'] : $IPNData['receiver_email'],
                $IPNData['mc_currency'],
                $IPNData['mc_gross']
            )
        ];
    }

}