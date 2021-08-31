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
 * @Title("MAGETWO-97502: Add default customer address via the Storefront7")
 * @Description("Storefront user should be able to create a new default address via the storefront2<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontUpdateCustomerAddressTest/StorefrontUpdateCustomerAddressFromGridTest.xml<br>")
 * @TestCaseId("MAGETWO-97502")
 * @group customer
 * @group update
 */
class StorefrontUpdateCustomerAddressFromGridTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_Multiple_Addresses", [], []); // stepKey: createCustomer
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
	 * @Stories({"Add default customer address via the Storefront7"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateCustomerAddressFromGridTest(AcceptanceTester $I)
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
		$I->click("//tbody//tr[1]//a[@class='action edit']"); // stepKey: editAdditionalAddress
		$I->waitForPageLoad(30); // stepKey: editAdditionalAddressWaitForPageLoad
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "EditedFirstName"); // stepKey: fillFirstName
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "EditedLastName"); // stepKey: fillLastName
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressWaitForPageLoad
		$I->see("You saved the address."); // stepKey: verifyAddressAdded
		$I->see("EditedFirstName", ".additional-addresses"); // stepKey: checkNewAddressFirstNameOnGrid
		$I->see("EditedLastName", ".additional-addresses"); // stepKey: checkNewAddressLastNameOnGrid
	}
}
