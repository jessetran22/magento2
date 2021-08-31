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
 * @Title("MC-5713: User should be able to delete Customer address successfully from storefront")
 * @Description("User should be able to delete Customer address successfully from storefront<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontDeleteCustomerAddressTest.xml<br>")
 * @TestCaseId("MC-5713")
 * @group Customer
 */
class StorefrontDeleteCustomerAddressTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
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
	 * @Stories({"Delete customer address from storefront"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontDeleteCustomerAddressTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageGoToSignInPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToSignInPage
		$I->comment("Exiting Action Group [goToSignInPage] StorefrontOpenCustomerLoginPageActionGroup");
		$I->comment("Entering Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailFillLoginFormWithCorrectCredentials
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordFillLoginFormWithCorrectCredentials
		$I->comment("Exiting Action Group [fillLoginFormWithCorrectCredentials] StorefrontFillCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->click("#send2"); // stepKey: clickSignInButtonClickSignInAccountButton
		$I->waitForPageLoad(30); // stepKey: clickSignInButtonClickSignInAccountButtonWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSignInClickSignInAccountButton
		$I->comment("Exiting Action Group [clickSignInAccountButton] StorefrontClickSignOnCustomerLoginFormActionGroup");
		$I->comment("Entering Action Group [enterAddressInfo] EnterCustomerAddressInfoActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: goToAddressPageEnterAddressInfo
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageEnterAddressInfo
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameEnterAddressInfo
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameEnterAddressInfo
		$I->fillField("#company", "368"); // stepKey: fillCompanyEnterAddressInfo
		$I->fillField("#telephone", "512-345-6789"); // stepKey: fillPhoneNumberEnterAddressInfo
		$I->fillField("#street_1", "368 Broadway St."); // stepKey: fillStreetAddress1EnterAddressInfo
		$I->fillField("#street_2", "113"); // stepKey: fillStreetAddress2EnterAddressInfo
		$I->fillField("#city", "New York"); // stepKey: fillCityNameEnterAddressInfo
		$I->selectOption("#country", "US"); // stepKey: selectCountyEnterAddressInfo
		$I->selectOption("#region_id", "New York"); // stepKey: selectStateEnterAddressInfo
		$I->fillField("#zip", "10001"); // stepKey: fillZipEnterAddressInfo
		$I->click("[data-action='save-address']"); // stepKey: saveAddressEnterAddressInfo
		$I->waitForPageLoad(30); // stepKey: saveAddressEnterAddressInfoWaitForPageLoad
		$I->comment("Exiting Action Group [enterAddressInfo] EnterCustomerAddressInfoActionGroup");
		$I->see("You saved the address."); // stepKey: verifyAddressCreated
		$I->click("//tbody//tr[1]//a[@class='action delete']"); // stepKey: deleteAdditionalAddress
		$I->waitForElementVisible("aside.confirm div.modal-content", 30); // stepKey: waitFortheConfirmationModal
		$I->see("Are you sure you want to delete this address?", "aside.confirm div.modal-content"); // stepKey: seeAddressDeleteConfirmationMessage
		$I->click("//footer[@class='modal-footer']/button[contains(@class, 'action-accept')]"); // stepKey: confirmDelete
		$I->waitForPageLoad(30); // stepKey: confirmDeleteWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForDeleteToFinish
		$I->see("You deleted the address."); // stepKey: verifyDeleteAddress
	}
}
