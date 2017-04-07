<?php namespace App\Controllers;

if(!defined('IN_APP')) {
  throw new \Exception("IN_APP not defined.");
}

use \App\Services\CustomerService;
use \App\Services\DvdService;
use \App\Services\LoanService;
use \App\Services\PaymentService;
use \Lib\Http404;

class LoanController extends BaseController {
  private $customerService;
  private $dvdService;
  private $loanService;
  private $paymentService;

  public function dispatch($request) {
    if(!$this->isLoggedIn()) {
      return $request->redirectToRoot();
    }
  }

  public function __construct() {
    $this->customerService = new CustomerService;
    $this->dvdService = new DvdService;
    $this->loanService = new LoanService;
    $this->paymentService = new PaymentService;
  }

  public function get($request) {
    if($request->getData('dvdId') && $request->getData('retDateTime')) {
      return $this->detail($request);
    }

    $loans = $this->loanService->getLoans(($request->getData('including_returned') ? true: false));

    return $this->render(
      $request,
      'loan-list.php',
      ['ctrl' => $this, 'loans' => $loans, 'request' => $request]
    );
  }

  public function detail($request) {
    $loan = $this->loanService->getLoan(
      $request->getData('dvdId'),
      $request->getData('retDateTime')
    );

    if(!$loan) {
      throw new Http404();
    }

    $payments = $this->paymentService->getPaymentsForLoan(
      $loan->getDvdId(),
      $loan->getReturnDateTime()
    );

    return $this->render(
      $request,
      'loan-detail.php',
      ['ctrl' => $this, 'loan' => $loan, 'payments' => $payments]
    );
  }

  public function newLoan($request) {
    return $this->render($request, 'loan-new.php', ['ctrl' => $this, 'request' => $request]);
  }

  public function post($request) {
    $errors = [];

    // Validate GET params presence
    if(empty($request->getData('dvdid')) || empty($request->getData('custid'))) {
      $errors[] = 'All fields have to be filled in.';
    } else {
      // Validate DVD
      $dvd = $this->dvdService->getDvd($request->getData('dvdid'));

      if (!$dvd) {
        $errors[] = 'Given DVD does not exist';
      } else {
        if ($this->loanService->isOnLoan($dvd->getId())) {
          $errors[] = 'DVD #' . $dvd->getId() . ' is already on loan';
        }
      }


      // Validate customer
      $customer = $this->customerService->getCustomer($request->getData('custid'));

      if (!$customer) {
        $errors[] = 'Given customer does not exist';
      }
    }

    if(count($errors)) {
      $_SESSION['flash'] = join('; ', $errors);

      return $this->render(
        $request,
        'loan-new.php',
        [
          'ctrl' => $this,
          'request' => $request,
          'customer' => isset($customer) ? $customer : NULL,
          'dvd' => isset($dvd) ? $dvd : NULL
        ]
      );
    }

    return $request->redirectTo(
      '/loans/new/payment/',
      ['dvdid' => $dvd->getId(), 'custid' => $customer->getId()]
    );
    
  }

  public function getPaymentTypeForm($request) {
    // Validate GET params
    if (empty($request->getData('dvdid')) || empty($request->getData('custid'))) {
      return $request->redirectTo(
        '/loans/new/'
      );
    }


    // Vaidate DVD
    $dvd = $this->dvdService->getDvd($request->getData('dvdid'));

    if (!$dvd) {
      $_SESSION['flash'] = "DVD does not exist";

      return $request->redirectTo(
        '/loans/new/'
      );
    } else {
      if ($this->loanService->isOnLoan($dvd->getId())) {
        $_SESSION['flash'] = "DVD is already on loan.";

        return $request->redirectTo(
          '/loans/new/'
        );
      }
    }


    // Validate customer
    $customer = $this->customerService->getCustomer($request->getData('custid'));

    if (!$customer) {
       $_SESSION['flash'] = "Customer does not exist.";

        return $request->redirectTo(
          '/loans/new/'
        );
    }


    // Get payment types
    $paymentTypes = $this->paymentService->getPaymentTypes();

    return $this->render(
      $request,
      'loan-new-payment-type.php',
      [
        'request' => $request,
        'customer' => $customer,
        'dvd' => $dvd,
        'paymentTypes' => $paymentTypes
      ]
    );
  }

  public function postPaymentTypeForm($request) {
    // Validate GET params presence
    if (empty($request->getData('dvdid')) || empty($request->getData('custid'))) {
      return $request->redirectTo(
        '/loans/new/'
      );
    }

    if (empty($request->getData('paymenttype'))) {
      return $request->redirectTo(
        '/loans/new/payment/',
        ['dvdid' => $request->getData('dvdid'), 'custid' => $request->getData('custid')]
      );
    }


    // Validate DVD
    $dvd = $this->dvdService->getDvd($request->getData('dvdid'));

    if (!$dvd) {
      $_SESSION['flash'] = "DVD does not exist";

      return $request->redirectTo(
        '/loans/new/'
      );
    } else {
      if ($this->loanService->isOnLoan($dvd->getId())) {
        $_SESSION['flash'] = "DVD is already on loan.";

        return $request->redirectTo(
          '/loans/new/'
        );
      }
    }


    // Validate customer
    $customer = $this->customerService->getCustomer($request->getData('custid'));

    if (!$customer) {
       $_SESSION['flash'] = "Customer does not exist.";

        return $request->redirectTo(
          '/loans/new/'
        );
    }


    // Validate payment type
    $paymentTypes = $this->paymentService->getPaymentTypes();

    $found = false;
    
    foreach($paymentTypes as $type) {
      if ($type->getId() == $request->getData('paymenttype')) {
        $found = true;
        break;
      }
    }

    if (!$found) {
      $_SESSION['flash'] = 'Wrong payment type';
      return $request->redirectTo(
        '/loans/new/payment/',
        ['dvdid' => $request->getData('dvdid'), 'custid' => $request->getData('custid')]
      );
    }

    return $request->redirectTo(
      '/loans/new/payment/details/',
      [
        'dvdid' => $request->getData('dvdid'),
        'custid' => $request->getData('custid'),
        'paymenttype' => $request->getData('paymenttype')
      ]
    );
  }

  public function getPaymentDetailsForm($request) {
    // Validate GET params presence
    if (empty($request->getData('dvdid')) || empty($request->getData('custid'))) {
      return $request->redirectTo(
        '/loans/new/'
      );
    }

    if (empty($request->getData('paymenttype'))) {
      return $request->redirectTo(
        '/loans/new/payment/',
        ['dvdid' => $request->getData('dvdid'), 'custid' => $request->getData('custid')]
      );
    }


    // Validate DVD
    $dvd = $this->dvdService->getDvd($request->getData('dvdid'));

    if (!$dvd) {
      $_SESSION['flash'] = "DVD does not exist";

      return $request->redirectTo(
        '/loans/new/'
      );
    } else {
      if ($this->loanService->isOnLoan($dvd->getId())) {
        $_SESSION['flash'] = "DVD is already on loan.";

        return $request->redirectTo(
          '/loans/new/'
        );
      }
    }

    
    // Validate customer
    $customer = $this->customerService->getCustomer($request->getData('custid'));

    if (!$customer) {
       $_SESSION['flash'] = "Customer does not exist.";

        return $request->redirectTo(
          '/loans/new/'
        );
    }


    // Validate payment type
    $paymentTypes = $this->paymentService->getPaymentTypes();

    $found = false;
    $currentPaymentType = NULL;
    
    foreach($paymentTypes as $type) {
      if ($type->getId() == $request->getData('paymenttype')) {
        $found = true;
        $currentPaymentType = $type;
        break;
      }
    }

    if (!$found) {
      $_SESSION['flash'] = 'Wrong payment type';
      return $request->redirectTo(
        '/loans/new/payment/',
        ['dvdid' => $request->getData('dvdid'), 'custid' => $request->getData('custid')]
      );
    }

    return $this->render(
      $request,
      'loan-new-payment-details.php',
      [
        'paymentType' => $currentPaymentType,
        'request' => $request,
        'dvd' => $dvd,
        'customer' => $customer
      ]
    );
  }

  public function postPaymentDetailsForm($request) {
    // Validate GET params presence
   if (empty($request->getData('dvdid')) || empty($request->getData('custid'))) {
      return $request->redirectTo(
        '/loans/new/'
      );
    }

    if (empty($request->getData('paymenttype'))) {
      return $request->redirectTo(
        '/loans/new/payment/',
        ['dvdid' => $request->getData('dvdid'), 'custid' => $request->getData('custid')]
      );
    }
    

    // Validate DVD
    $dvd = $this->dvdService->getDvd($request->getData('dvdid'));

    if (!$dvd) {
      $_SESSION['flash'] = "DVD does not exist";

      return $request->redirectTo(
        '/loans/new/'
      );
    } else {
      if ($this->loanService->isOnLoan($dvd->getId())) {
        $_SESSION['flash'] = "DVD is already on loan.";

        return $request->redirectTo(
          '/loans/new/'
        );
      }
    }


    // Validate customer
    $customer = $this->customerService->getCustomer($request->getData('custid'));

    if (!$customer) {
       $_SESSION['flash'] = "Customer does not exist.";

        return $request->redirectTo(
          '/loans/new/'
        );
    }


    // Validate payment type
    $paymentTypes = $this->paymentService->getPaymentTypes();

    $found = false;
    $currentPaymentType = NULL;
    
    foreach($paymentTypes as $type) {
      if ($type->getId() == $request->getData('paymenttype')) {
        $found = true;
        $currentPaymentType = $type;
        break;
      }
    }

    if (!$found) {
      $_SESSION['flash'] = 'Wrong payment type';
      return $request->redirectTo(
        '/loans/new/payment/',
        [
          'dvdid' => $request->getData('dvdid'),
          'custid' => $request->getData('custid')
        ]
      );
    }


    // Validate payment form
    $errors = [];

    if (empty($request->getData('amount'))) {
      $errors[] = 'Amonut cannot be empty'; 
    } else {
      if (((float) $request->getData('amount')) < 0) {
        $errors[] = 'Amount has to be larger than 0.';
      }
    }

    // Validate payment type specific data

    switch ($currentPaymentType->getId()) {
      case 1:
        // There's no extra validation for cash payment
        break;
      case 2:
        if (empty($request->getData('bankno'))
            || empty($request->getData('bankname'))
            || empty($request->getData('chequeno'))
          ) {
          $errors[] = 'All fields are required';
        }
        break;
      case 3:
        if (empty($request->getData('dcno'))
            || empty($request->getData('dctype'))
            || empty($request->getData('expirymonth'))
            || empty($request->getData('expirymonth'))
        ) {
          $errors[] = 'All fields are required';
        }

        if ((int) $request->getData('expirymonth') < 1 && (int) $request->getData('expirymonth') > 12) {
          $errors[] = 'Expiry month must be 1 - 12.';
        }

        if ((int) $request->getData('expiryyear') < date('Y')) {
          $errors[] = 'Expiry year cannot be in the past.';
        }

        if ((int) $request->getData('expirymonth') < 10) {
          $dcexpr = "0" . (int) $request->getData('expirymonth');
        } else {
          $dcexpr = (string) ((int) $request->getData('expirymonth'));
        }

        $dcexpr .= ':' . substr($request->getData('expiryyear'), 2);
        break;
      case 4:
        if (empty($request->getData('ccno'))
              || empty($request->getData('cctype'))
              || empty($request->getData('expirymonth'))
              || empty($request->getData('expirymonth'))
        ) {
          $errors[] = 'All fields are required';
        }

        if ((int) $request->getData('expirymonth') < 1 && (int) $request->getData('expirymonth') > 12) {
          $errors[] = 'Expiry month must be 1 - 12.';
        }

        if ((int) $request->getData('expiryyear') < date('Y')) {
          $errors[] = 'Expiry year cannot be in the past.';
        }

        if ((int) $request->getData('expirymonth') < 10) {
          $ccexpr = "0" . (int) $request->getData('expirymonth');
        } else {
          $ccexpr = (string) ((int) $request->getData('expirymonth'));
        }

        $ccexpr .= ':' . substr($request->getData('expiryyear'), 2);
        break;
      default:
        throw new \Exception('Payment type validation for
                             ' . $currentPaymentType->getId() . '
                             not implemented');
    }

    if (count($errors)) {
      $_SESSION['flash'] = join('; ', $errors);

      return $this->render(
        $request,
        'loan-new-payment-details.php',
        [
          'paymentType' => $currentPaymentType,
          'request' => $request,
          'dvd' => $dvd,
          'customer' => $customer
        ]
      );
    }

    // Create payment object
    $payment = NULL;

    switch ($currentPaymentType->getId()) {
      case 1:
        $payment = $this->paymentService->createCashPayment(
          (float) $request->getData('amount'),
          $this->getCurrentUser(),
          $customer
        );
        break;
      case 2:
        $payment = $this->paymentService->createChequePayment(
          (float) $request->getData('amount'),
          $this->getCurrentUser(),
          $customer,
          $request->getData('chequeno'),
          $request->getData('bankno'),
          $request->getData('bankname')
        );
        break;
      case 3:
        $payment = $this->paymentService->createDebitCardPayment(
          (float) $request->getData('amount'),
          $this->getCurrentUser(),
          $customer,
          $request->getData('dcno'),
          $request->getData('dctype'),
          $dcexpr
        );
        break;
      case 4:
        $payment = $this->paymentService->createCreditCardPayment(
          (float) $request->getData('amount'),
          $this->getCurrentUser(),
          $customer,
          $request->getData('ccno'),
          $request->getData('cctype'),
          $ccexpr
        );
        break;
      default:
        throw new \Exception(
          'Payment type id ' . $currentPaymentType->getId() . '
          submission not implemented'
        );
    }

    if (!$payment) {
      $_SESSION['flash'] = 'Payment could not be added';

      return $this->render(
        $request,
        'loan-new-payment-details.php',
        [
          'paymentType' => $currentPaymentType,
          'request' => $request,
          'dvd' => $dvd,
          'customer' => $customer
        ]
      );
    }

    $loan = $this->loanService->createLoan(
      $dvd,
      $customer,
      $this->getCurrentUser(),
      $payment
    );

    if (!$loan) {
       $_SESSION['flash'] = "Please input valid data.";

      return $this->render(
        $request,
        'loan-new-payment-details.php',
        [
          'ctrl' => $this,
          'request' => $request,
          'customer' => $customer,
          'dvd' => $dvd,
          'paymentType' => $currentPaymentType
        ]
      );
    }

    $_SESSION['flash'] = 'Loaned a DVD out.';

    return $request->redirectTo(
      '/loans/',
      [
        'dvdId' => $loan->getDvdId(),
        'retDateTime' => $loan->getReturnDateTime()
      ]
    );
  }

  public function acceptReturnGet($request) {
    $loan = $this->loanService->getLoan(
      $request->getData('dvdId'),
      $request->getData('retDateTime')
    );

    if(!$loan || $loan->getStatusId() == 2) {
      throw new Http404();
    }

    return $this->render($request, 'loan-accept-return.php', ['ctrl' => $this, 'loan' => $loan]);
  }

  public function acceptReturnPost($request) {
    $loan = $this->loanService->getLoan(
      $request->getData('dvdId'),
      $request->getData('retDateTime')
    );

    if(!$loan || $loan->getStatusId() == 2) {
      throw new Http404();
    }

    // Set new date so we know the new primary key
    $date = date('Y-m-d');
    $result = $this->loanService->acceptReturn($loan, $date);

    if($result) {
      $_SESSION['flash'] = 'Accepted return';
    } else {
      $_SESSION['flash'] = 'Internal error. DVD could not be marked as returned.';
    }

    return $request->redirectTo('/loans/', ['dvdId' => $loan->getDvdId(), 'retDateTime' => $date]);
  }
}
