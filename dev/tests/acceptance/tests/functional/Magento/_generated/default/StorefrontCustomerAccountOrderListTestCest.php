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
 * @Title("MC-34953: Verify that the list of Orders is displayed in the grid after changing the number of items on the page")
 * @Description("Verify that the list of Orders is displayed in the grid after changing the number of items on the page.<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCustomerAccountOrderListTest.xml<br>")
 * @TestCaseId("MC-34953")
 * @group customer
 */
class StorefrontCustomerAccountOrderListTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Create Product via API");
		$I->createEntity("Product", "hook", "SimpleProduct2", [], []); // stepKey: Product
		$I->comment("Create Customer via API");
		$I->createEntity("Customer", "hook", "Simple_US_Customer", [], []); // stepKey: Customer
		$I->comment("Create Orders via API");
		$I->comment("Entering Action Group [createCustomerOrder1] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder1", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder1
		$I->createEntity("addCartItemCreateCustomerOrder1", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder1", "Product"], []); // stepKey: addCartItemCreateCustomerOrder1
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder1", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder1"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder1
		$I->updateEntity("CustomerCartCreateCustomerOrder1", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder1"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder1
		$I->comment("Exiting Action Group [createCustomerOrder1] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder2] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder2", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder2
		$I->createEntity("addCartItemCreateCustomerOrder2", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder2", "Product"], []); // stepKey: addCartItemCreateCustomerOrder2
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder2", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder2"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder2
		$I->updateEntity("CustomerCartCreateCustomerOrder2", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder2"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder2
		$I->comment("Exiting Action Group [createCustomerOrder2] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder3] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder3", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder3
		$I->createEntity("addCartItemCreateCustomerOrder3", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder3", "Product"], []); // stepKey: addCartItemCreateCustomerOrder3
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder3", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder3"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder3
		$I->updateEntity("CustomerCartCreateCustomerOrder3", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder3"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder3
		$I->comment("Exiting Action Group [createCustomerOrder3] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder4] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder4", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder4
		$I->createEntity("addCartItemCreateCustomerOrder4", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder4", "Product"], []); // stepKey: addCartItemCreateCustomerOrder4
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder4", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder4"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder4
		$I->updateEntity("CustomerCartCreateCustomerOrder4", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder4"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder4
		$I->comment("Exiting Action Group [createCustomerOrder4] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder5] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder5", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder5
		$I->createEntity("addCartItemCreateCustomerOrder5", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder5", "Product"], []); // stepKey: addCartItemCreateCustomerOrder5
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder5", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder5"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder5
		$I->updateEntity("CustomerCartCreateCustomerOrder5", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder5"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder5
		$I->comment("Exiting Action Group [createCustomerOrder5] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder6] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder6", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder6
		$I->createEntity("addCartItemCreateCustomerOrder6", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder6", "Product"], []); // stepKey: addCartItemCreateCustomerOrder6
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder6", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder6"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder6
		$I->updateEntity("CustomerCartCreateCustomerOrder6", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder6"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder6
		$I->comment("Exiting Action Group [createCustomerOrder6] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder7] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder7", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder7
		$I->createEntity("addCartItemCreateCustomerOrder7", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder7", "Product"], []); // stepKey: addCartItemCreateCustomerOrder7
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder7", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder7"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder7
		$I->updateEntity("CustomerCartCreateCustomerOrder7", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder7"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder7
		$I->comment("Exiting Action Group [createCustomerOrder7] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder8] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder8", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder8
		$I->createEntity("addCartItemCreateCustomerOrder8", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder8", "Product"], []); // stepKey: addCartItemCreateCustomerOrder8
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder8", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder8"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder8
		$I->updateEntity("CustomerCartCreateCustomerOrder8", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder8"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder8
		$I->comment("Exiting Action Group [createCustomerOrder8] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder9] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder9", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder9
		$I->createEntity("addCartItemCreateCustomerOrder9", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder9", "Product"], []); // stepKey: addCartItemCreateCustomerOrder9
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder9", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder9"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder9
		$I->updateEntity("CustomerCartCreateCustomerOrder9", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder9"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder9
		$I->comment("Exiting Action Group [createCustomerOrder9] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder10] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder10", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder10
		$I->createEntity("addCartItemCreateCustomerOrder10", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder10", "Product"], []); // stepKey: addCartItemCreateCustomerOrder10
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder10", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder10"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder10
		$I->updateEntity("CustomerCartCreateCustomerOrder10", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder10"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder10
		$I->comment("Exiting Action Group [createCustomerOrder10] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder11] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder11", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder11
		$I->createEntity("addCartItemCreateCustomerOrder11", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder11", "Product"], []); // stepKey: addCartItemCreateCustomerOrder11
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder11", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder11"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder11
		$I->updateEntity("CustomerCartCreateCustomerOrder11", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder11"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder11
		$I->comment("Exiting Action Group [createCustomerOrder11] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder12] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder12", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder12
		$I->createEntity("addCartItemCreateCustomerOrder12", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder12", "Product"], []); // stepKey: addCartItemCreateCustomerOrder12
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder12", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder12"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder12
		$I->updateEntity("CustomerCartCreateCustomerOrder12", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder12"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder12
		$I->comment("Exiting Action Group [createCustomerOrder12] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder13] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder13", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder13
		$I->createEntity("addCartItemCreateCustomerOrder13", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder13", "Product"], []); // stepKey: addCartItemCreateCustomerOrder13
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder13", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder13"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder13
		$I->updateEntity("CustomerCartCreateCustomerOrder13", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder13"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder13
		$I->comment("Exiting Action Group [createCustomerOrder13] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder14] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder14", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder14
		$I->createEntity("addCartItemCreateCustomerOrder14", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder14", "Product"], []); // stepKey: addCartItemCreateCustomerOrder14
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder14", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder14"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder14
		$I->updateEntity("CustomerCartCreateCustomerOrder14", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder14"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder14
		$I->comment("Exiting Action Group [createCustomerOrder14] CreateCustomerOrderActionGroup");
		$I->comment("Entering Action Group [createCustomerOrder15] CreateCustomerOrderActionGroup");
		$I->createEntity("CustomerCartCreateCustomerOrder15", "hook", "CustomerCart", ["Customer"], []); // stepKey: CustomerCartCreateCustomerOrder15
		$I->createEntity("addCartItemCreateCustomerOrder15", "hook", "CustomerCartItem", ["CustomerCartCreateCustomerOrder15", "Product"], []); // stepKey: addCartItemCreateCustomerOrder15
		$I->createEntity("addCustomerOrderAddressCreateCustomerOrder15", "hook", "CustomerAddressInformation", ["CustomerCartCreateCustomerOrder15"], []); // stepKey: addCustomerOrderAddressCreateCustomerOrder15
		$I->updateEntity("CustomerCartCreateCustomerOrder15", "hook", "CustomerOrderPaymentMethod",["CustomerCartCreateCustomerOrder15"]); // stepKey: sendCustomerPaymentInformationCreateCustomerOrder15
		$I->comment("Exiting Action Group [createCustomerOrder15] CreateCustomerOrderActionGroup");
		$I->comment("Create Orders via API");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->amOnPage("customer/account/logout/"); // stepKey: storefrontSignOutCustomerLogout
		$I->waitForPageLoad(30); // stepKey: waitForSignOutCustomerLogout
		$I->comment("Exiting Action Group [customerLogout] StorefrontCustomerLogoutActionGroup");
		$I->deleteEntity("Product", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("Customer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Frontend Customer Account Orders list"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCustomerAccountOrderListTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginToStorefront] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLoginToStorefront
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLoginToStorefront
		$I->fillField("#email", $I->retrieveEntityField('Customer', 'email', 'test')); // stepKey: fillEmailLoginToStorefront
		$I->fillField("#pass", $I->retrieveEntityField('Customer', 'password', 'test')); // stepKey: fillPasswordLoginToStorefront
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLoginToStorefront
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLoginToStorefrontWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLoginToStorefront
		$I->comment("Exiting Action Group [loginToStorefront] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [goToSidebarMenu] StorefrontCustomerGoToSidebarMenu");
		$I->click("//div[@id='block-collapsible-nav']//a[text()='My Orders']"); // stepKey: goToAddressBookGoToSidebarMenu
		$I->waitForPageLoad(60); // stepKey: goToAddressBookGoToSidebarMenuWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToSidebarMenu
		$I->comment("Exiting Action Group [goToSidebarMenu] StorefrontCustomerGoToSidebarMenu");
		$I->seeElement("//*[@class='page-title']//*[contains(text(), 'My Orders')]"); // stepKey: waitOrderHistoryPage
		$I->scrollTo(".order-products-toolbar .pages .current span:nth-of-type(2)"); // stepKey: scrollToBottomToolbarSection
		$I->click("//*[@class='order-products-toolbar toolbar bottom']//a[contains(@class, 'page')]//span[2][contains(text() ,'2')]"); // stepKey: clickOnPage2
		$I->scrollTo("//*[@class='order-products-toolbar toolbar bottom']//select[@id='limiter']"); // stepKey: scrollToLimiter
		$I->selectOption("//*[@class='order-products-toolbar toolbar bottom']//select[@id='limiter']", "20"); // stepKey: selectLimitOnPage
		$I->waitForPageLoad(30); // stepKey: waitForLoadPage
		$I->seeElement("//*[@class='page-title']//*[contains(text(), 'My Orders')]"); // stepKey: seeElementOrderHistoryPage
		$I->dontSee("You have placed no orders.", "//div[contains(concat(' ',normalize-space(@class),' '),' message info empty ')]/span"); // stepKey: dontSeeEmptyMessage
		$I->seeNumberOfElements("//tbody/tr/td[contains(@class, 'id')]", "15"); // stepKey: seeRowsCount
	}
}
