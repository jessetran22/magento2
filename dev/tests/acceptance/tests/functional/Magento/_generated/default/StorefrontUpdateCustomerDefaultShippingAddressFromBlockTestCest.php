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
 * @Title("MC-40247: Update customer default shipping address via the Storefront")
 * @Description("Customer should be able to update a default shipping address via the Storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontUpdateCustomerAddressTest/StorefrontUpdateCustomerDefaultShippingAddressFromBlockTest.xml<br>")
 * @TestCaseId("MC-40247")
 * @group customer
 * @group update
 */
class StorefrontUpdateCustomerDefaultShippingAddressFromBlockTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_With_Different_Billing_Shipping_Addresses", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: DeleteCustomer
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
	 * @Stories({"Update Customer Address"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateCustomerDefaultShippingAddressFromBlockTest(AcceptanceTester $I)
	{
		$I->comment("Log in to Storefront as Customer 1");
		$I->comment("Entering Action Group [signUp] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageSignUp
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedSignUp
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsSignUp
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailSignUp
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordSignUp
		$I->click("#send2"); // stepKey: clickSignInAccountButtonSignUp
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonSignUpWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInSignUp
		$I->comment("Exiting Action Group [signUp] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/address/"); // stepKey: OpenCustomerAddNewAddress
		$I->waitForElementVisible("//div[@class='box-actions']//span[text()='Change Shipping Address']", 30); // stepKey: waitForChangeShippingAddressLinkVisible
		$I->waitForPageLoad(30); // stepKey: waitForChangeShippingAddressLinkVisibleWaitForPageLoad
		$I->click("//div[@class='box-actions']//span[text()='Change Shipping Address']"); // stepKey: ClickEditDefaultShippingAddress
		$I->waitForPageLoad(30); // stepKey: ClickEditDefaultShippingAddressWaitForPageLoad
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "EditedFirstNameShipping"); // stepKey: fillFirstName
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "EditedLastNameShipping"); // stepKey: fillLastName
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageVisible
		$I->see("You saved the address.", "div.message-success.success.message"); // stepKey: verifyAddressAdded
		$I->see("EditedFirstNameShipping", ".box-address-shipping"); // stepKey: checkNewAddressesFirstNameOnDefaultShipping
		$I->see("EditedLastNameShipping", ".box-address-shipping"); // stepKey: checkNewAddressesLastNameOnDefaultShipping
		$I->see("John", ".box-address-billing"); // stepKey: checkNewAddressesFirstNameOnDefaultBilling
		$I->see("Doe", ".box-address-billing"); // stepKey: checkNewAddressesLastNameOnDefaultBilling
	}
}
