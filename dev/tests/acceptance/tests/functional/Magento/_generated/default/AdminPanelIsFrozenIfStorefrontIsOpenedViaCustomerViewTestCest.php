<?php
namespace Magento\AcceptanceTest\_default\Backend;

use Magento\FunctionalTestingFramework\AcceptanceTester;
use \Codeception\Util\Locator;
use Yandex\Allure\Adapter\Annotation\Features;
use Yandex\Allure\Adapter\Annotation\Stories;
use Yandex\Allure\Adapter\Annotation\Title;
use Yandex\Allure\Adapter\Annotation\Description;
use Yandex\Allure\Adapter\Annotation\Parameter;
use Yandex\Allure\Adapter\Annotation\Severity;
use Yandex\Allure\Adapter\Model\SeverityLevel;
use Yandex\Allure\Adapter\Annotation\TestCaseId;

/**
 * @Title("https://github.com/magento/magento2/pull/24845: Place an order and click print")
 * @Description("Admin panel is not frozen if Storefront is opened via Customer View<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/AdminPanelIsFrozenIfStorefrontIsOpenedViaCustomerViewTest.xml<br>")
 * @TestCaseId("https://github.com/magento/magento2/pull/24845")
 * @group customer
 */
class AdminPanelIsFrozenIfStorefrontIsOpenedViaCustomerViewTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("simpleCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: simpleCustomer
		$I->createEntity("createSimpleCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSimpleCategory
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct", ["createSimpleCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Comment is added to preserve the step key for backward compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createSimpleCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _failed(AcceptanceTester $I)
	{
		$I->saveScreenshot(); // stepKey: saveScreenshot
	}

	/**
	 * @Features({"Customer"})
	 * @Stories({"Customer Order"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminPanelIsFrozenIfStorefrontIsOpenedViaCustomerViewTest(AcceptanceTester $I)
	{
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->createEntity("createCustomerCart", "test", "CustomerCart", ["simpleCustomer"], []); // stepKey: createCustomerCart
		$I->createEntity("addSecondProduct", "test", "CustomerCartItem", ["createCustomerCart", "createSimpleProduct"], []); // stepKey: addSecondProduct
		$I->createEntity("fillCustomerInfo", "test", "CustomerAddressInformation", ["createCustomerCart"], []); // stepKey: fillCustomerInfo
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->updateEntity("createCustomerCart", "test", "CustomerOrderPaymentMethod",["createCustomerCart"]); // stepKey: submitOrder
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->createEntity("submitInvoice", "test", "Invoice", ["createCustomerCart"], []); // stepKey: submitInvoice
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->createEntity("submitShipment", "test", "Shipment", ["createCustomerCart"], []); // stepKey: submitShipment
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->createEntity("submitCreditMemo", "test", "CreditMemo", ["createCustomerCart"], []); // stepKey: submitCreditMemo
		$I->comment("Entering Action Group [logInCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLogInCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLogInCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLogInCustomer
		$I->fillField("#email", $I->retrieveEntityField('simpleCustomer', 'email', 'test')); // stepKey: fillEmailLogInCustomer
		$I->fillField("#pass", $I->retrieveEntityField('simpleCustomer', 'password', 'test')); // stepKey: fillPasswordLogInCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLogInCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLogInCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLogInCustomer
		$I->comment("Exiting Action Group [logInCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [goToMyOrdersPage] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: goToAddressBookGoToMyOrdersPage
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToMyOrdersPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToMyOrdersPage
		$I->comment("Exiting Action Group [goToMyOrdersPage] StorefrontCustomerGoToSidebarMenu");
		$I->comment("Entering Action Group [clickViewOrder] StorefrontClickViewOrderLinkOnMyOrdersPageActionGroup");
		$I->click("//td[contains(concat(' ',normalize-space(@class),' '),' col actions ')]/a[contains(concat(' ',normalize-space(@class),' '),' action view ')]"); // stepKey: clickViewOrderClickViewOrder
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickViewOrder
		$I->comment("Exiting Action Group [clickViewOrder] StorefrontClickViewOrderLinkOnMyOrdersPageActionGroup");
		$I->comment("Entering Action Group [clickPrintOrderLink] StorefrontClickPrintOrderLinkOnViewOrderPageActionGroup");
		$I->click("a.action.print"); // stepKey: clickPrintOrderLinkClickPrintOrderLink
		$I->waitForPageLoad(30); // stepKey: clickPrintOrderLinkClickPrintOrderLinkWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedClickPrintOrderLink
		$I->comment("Exiting Action Group [clickPrintOrderLink] StorefrontClickPrintOrderLinkOnViewOrderPageActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->switchToWindow(); // stepKey: switchToWindow
		$I->switchToPreviousTab(); // stepKey: switchToPreviousTab
		$I->comment("Entering Action Group [goToAddressBook] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='Address Book']"); // stepKey: goToAddressBookGoToAddressBook
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToAddressBookWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToAddressBook
		$I->comment("Exiting Action Group [goToAddressBook] StorefrontCustomerGoToSidebarMenu");
		$I->see("7700 West Parmer Lane Austin, Texas, 78729", "//*[@class='box box-address-shipping']//address"); // stepKey: checkShippingAddress
	}
}
