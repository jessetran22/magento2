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
 * @Title("MAGETWO-97364: Storefront - My account - Address Book - add new address")
 * @Description("Storefront user should be able to create a new address via the storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontAddCustomerAddressTest/StorefrontAddNewCustomerAddressTest.xml<br>")
 * @TestCaseId("MAGETWO-97364")
 * @group customer
 * @group create
 */
class StorefrontAddNewCustomerAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_Customer_Without_Address", [], []); // stepKey: createCustomer
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
	public function StorefrontAddNewCustomerAddressTest(AcceptanceTester $I)
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
		$I->comment("Entering Action Group [AddNewAddress] StorefrontAddNewCustomerAddressActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: OpenCustomerAddNewAddressAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'firstname')]", "John"); // stepKey: fillFirstNameAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'lastname')]", "Doe"); // stepKey: fillLastNameAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'company')]", "Magento"); // stepKey: fillCompanyNameAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'telephone')]", "512-345-6789"); // stepKey: fillPhoneNumberAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'street')]", "7700 West Parmer Lane"); // stepKey: fillStreetAddressAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'city')]", "Austin"); // stepKey: fillCityAddNewAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'region_id')]", "Texas"); // stepKey: selectStateAddNewAddress
		$I->fillField("//form[@class='form-address-edit']//input[contains(@name, 'postcode')]", "78729"); // stepKey: fillZipAddNewAddress
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'country_id')]", "United States"); // stepKey: selectCountryAddNewAddress
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddressAddNewAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressAddNewAddressWaitForPageLoad
		$I->see("You saved the address."); // stepKey: verifyAddressAddedAddNewAddress
		$I->comment("Exiting Action Group [AddNewAddress] StorefrontAddNewCustomerAddressActionGroup");
		$I->see("7700 West Parmer Lane", ".box-address-billing"); // stepKey: checkNewAddressesStreetOnDefaultBilling
		$I->see("Austin", ".box-address-billing"); // stepKey: checkNewAddressesCityOnDefaultBilling
		$I->see("78729", ".box-address-billing"); // stepKey: checkNewAddressesPostcodeOnDefaultBilling
		$I->see("7700 West Parmer Lane", ".box-address-shipping"); // stepKey: checkNewAddressesStreetOnDefaultShipping
		$I->see("Austin", ".box-address-shipping"); // stepKey: checkNewAddressesCityOnDefaultShipping
		$I->see("78729", ".box-address-shipping"); // stepKey: checkNewAddressesPostcodeOnDefaultShipping
	}
}
