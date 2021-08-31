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
 * @Title("MAGETWO-97501: Add default customer address via the Storefront6")
 * @Description("Storefront user should be able to create a new default address via the storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontUpdateCustomerAddressTest/StorefrontUpdateCustomerDefaultBillingAddressFromBlockTest.xml<br>")
 * @TestCaseId("MAGETWO-97501")
 * @group customer
 * @group update
 */
class StorefrontUpdateCustomerDefaultBillingAddressFromBlockTestCest
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
	 * @Stories({"Implement handling of large number of addresses on storefront Address book"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateCustomerDefaultBillingAddressFromBlockTest(AcceptanceTester $I)
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
		$I->amOnPage("customer/address/"); // stepKey: OpenCustomerAddNewAddress
		$I->click("//div[@class='box-actions']//span[text()='Change Billing Address']"); // stepKey: ClickEditDefaultBillingAddress
		$I->waitForPageLoad(30); // stepKey: ClickEditDefaultBillingAddressWaitForPageLoad
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "EditedFirstNameBilling"); // stepKey: fillFirstName
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "EditedLastNameBilling"); // stepKey: fillLastName
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressWaitForPageLoad
		$I->see("You saved the address."); // stepKey: verifyAddressAdded
		$I->see("EditedFirstNameBilling", ".box-address-billing"); // stepKey: checkNewAddressesFirstNameOnDefaultBilling
		$I->see("EditedLastNameBilling", ".box-address-billing"); // stepKey: checkNewAddressesLastNameOnDefaultBilling
		$I->see("John", ".box-address-shipping"); // stepKey: checkNewAddressesFirstNameOnDefaultShipping
		$I->see("Doe", ".box-address-shipping"); // stepKey: checkNewAddressesLastNameOnDefaultShipping
	}
}
