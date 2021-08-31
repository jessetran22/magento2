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
 * @Title("MAGETWO-97500: Storefront - My account - Address Book - add new non default billing/shipping address")
 * @Description("Storefront user should be able to create a new non default address via the storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontAddCustomerAddressTest/StorefrontAddCustomerNonDefaultAddressTest.xml<br>")
 * @TestCaseId("MAGETWO-97500")
 * @group customer
 * @group create
 */
class StorefrontAddCustomerNonDefaultAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer_NY", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: DeleteCustomer
		$I->comment("Entering Action Group [adminLogout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAdminLogout
		$I->comment("Exiting Action Group [adminLogout] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddCustomerNonDefaultAddressTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [AddNewNonDefaultAddress] StorefrontAddNewCustomerAddressActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: OpenCustomerAddNewAddressAddNewNonDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "John"); // stepKey: fillFirstNameAddNewNonDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "Doe"); // stepKey: fillLastNameAddNewNonDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'company')]", "Magento"); // stepKey: fillCompanyNameAddNewNonDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'telephone')]", "512-345-6789"); // stepKey: fillPhoneNumberAddNewNonDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'street')]", "7700 West Parmer Lane"); // stepKey: fillStreetAddressAddNewNonDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'city')]", "Austin"); // stepKey: fillCityAddNewNonDefaultAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'region_id')]", "Texas"); // stepKey: selectStateAddNewNonDefaultAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'postcode')]", "78729"); // stepKey: fillZipAddNewNonDefaultAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'country_id')]", "United States"); // stepKey: selectCountryAddNewNonDefaultAddress
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddressAddNewNonDefaultAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressAddNewNonDefaultAddressWaitForPageLoad
		$I->see("You saved the address."); // stepKey: verifyAddressAddedAddNewNonDefaultAddress
		$I->comment("Exiting Action Group [AddNewNonDefaultAddress] StorefrontAddNewCustomerAddressActionGroup");
		$I->see("7700 West Parmer Lane", ".additional-addresses"); // stepKey: checkNewAddressesStreetOnDefaultShipping
		$I->see("Austin", ".additional-addresses"); // stepKey: checkNewAddressesCityOnDefaultShipping
		$I->see("78729", ".additional-addresses"); // stepKey: checkNewAddressesPostcodeOnDefaultShipping
	}
}
