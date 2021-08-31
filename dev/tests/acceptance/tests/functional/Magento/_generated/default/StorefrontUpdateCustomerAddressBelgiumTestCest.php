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
 * @Title("MC-20234: Update customer address on storefront with Belgium address")
 * @Description("Update customer address on storefront with Belgium address and verify you can select a region<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontUpdateCustomerAddressBelgiumTest.xml<br>")
 * @TestCaseId("MC-20234")
 * @group customer
 */
class StorefrontUpdateCustomerAddressBelgiumTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->amOnPage("/customer/account/create/"); // stepKey: goToCustomerAccountCreatePageOpenCreateAccountPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCreateAccountPage
		$I->comment("Exiting Action Group [openCreateAccountPage] StorefrontOpenCustomerAccountCreatePageActionGroup");
		$I->comment("Entering Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameFillCreateAccountForm
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameFillCreateAccountForm
		$I->fillField("#email_address", msq("CustomerEntityOne") . "test@email.com"); // stepKey: fillEmailFillCreateAccountForm
		$I->fillField("#password", "pwdTest123!"); // stepKey: fillPasswordFillCreateAccountForm
		$I->fillField("#password-confirmation", "pwdTest123!"); // stepKey: fillConfirmPasswordFillCreateAccountForm
		$I->comment("Exiting Action Group [fillCreateAccountForm] StorefrontFillCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForCreateAccountButtonIsActiveSubmitCreateAccountForm
		$I->click("button.action.submit.primary"); // stepKey: clickCreateAccountButtonSubmitCreateAccountForm
		$I->waitForPageLoad(30); // stepKey: clickCreateAccountButtonSubmitCreateAccountFormWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerSavedSubmitCreateAccountForm
		$I->comment("Exiting Action Group [submitCreateAccountForm] StorefrontClickCreateAnAccountCustomerAccountCreationFormActionGroup");
		$I->comment("Entering Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
		$I->see("Thank you for registering with Main Website Store.", "#maincontent .message-success"); // stepKey: verifyMessageSeeSuccessMessage
		$I->comment("Exiting Action Group [seeSuccessMessage] AssertMessageCustomerCreateAccountActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [deleteNewUser] DeleteCustomerByEmailActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/index/"); // stepKey: navigateToCustomersDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForAdminCustomerPageLoadDeleteNewUser
		$I->click("#container > div > div.admin__data-grid-header > div:nth-child(1) > div.data-grid-filters-actions-wrap > div > button"); // stepKey: clickFilterButtonDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickFilterButtonDeleteNewUserWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteNewUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForClearFiltersDeleteNewUser
		$I->fillField("input[name=email]", msq("CustomerEntityOne") . "test@email.com"); // stepKey: filterEmailDeleteNewUser
		$I->click("button[data-action=grid-filter-apply]"); // stepKey: applyFilterDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: applyFilterDeleteNewUserWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadDeleteNewUser
		$I->click("//td[@class='data-grid-checkbox-cell']"); // stepKey: clickOnEditButton1DeleteNewUser
		$I->click("//div[@class='col-xs-2']/div[@class='action-select-wrap']/button[@class='action-select']"); // stepKey: clickActionsDropdownDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickActionsDropdownDeleteNewUserWaitForPageLoad
		$I->click("//*[contains(@class,'admin__data-grid-header-row row row-gutter')]//*[text()='Delete']"); // stepKey: clickDeleteDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteNewUserWaitForPageLoad
		$I->waitForElementVisible("//button[@data-role='action']//span[text()='OK']", 30); // stepKey: waitForOkToVisibleDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: waitForOkToVisibleDeleteNewUserWaitForPageLoad
		$I->click("//button[@data-role='action']//span[text()='OK']"); // stepKey: clickOkConfirmationButtonDeleteNewUser
		$I->waitForPageLoad(30); // stepKey: clickOkConfirmationButtonDeleteNewUserWaitForPageLoad
		$I->waitForElementVisible("//*[@class='message message-success success']", 30); // stepKey: waitForSuccessfullyDeletedMessageDeleteNewUser
		$I->comment("Exiting Action Group [deleteNewUser] DeleteCustomerByEmailActionGroup");
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
	 * @Stories({"Update Regions list for Belgium country"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateCustomerAddressBelgiumTest(AcceptanceTester $I)
	{
		$I->comment("Update customer address Belgium in storefront");
		$I->comment("Entering Action Group [enterAddress] EnterCustomerAddressInfoActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: goToAddressPageEnterAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageEnterAddress
		$I->fillField("#firstname", "John"); // stepKey: fillFirstNameEnterAddress
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameEnterAddress
		$I->fillField("#company", "Magento"); // stepKey: fillCompanyEnterAddress
		$I->fillField("#telephone", "0477-58-77867"); // stepKey: fillPhoneNumberEnterAddress
		$I->fillField("#street_1", "Chaussee de Wavre"); // stepKey: fillStreetAddress1EnterAddress
		$I->fillField("#street_2", "318"); // stepKey: fillStreetAddress2EnterAddress
		$I->fillField("#city", "Bihain"); // stepKey: fillCityNameEnterAddress
		$I->selectOption("#country", "BE"); // stepKey: selectCountyEnterAddress
		$I->selectOption("#region_id", "Hainaut"); // stepKey: selectStateEnterAddress
		$I->fillField("#zip", "6690"); // stepKey: fillZipEnterAddress
		$I->click("[data-action='save-address']"); // stepKey: saveAddressEnterAddress
		$I->waitForPageLoad(30); // stepKey: saveAddressEnterAddressWaitForPageLoad
		$I->comment("Exiting Action Group [enterAddress] EnterCustomerAddressInfoActionGroup");
		$I->comment("Verify customer address save success message");
		$I->see("You saved the address.", ".message-success"); // stepKey: seeAssertCustomerAddressSuccessSaveMessage
		$I->comment("Verify customer default billing address");
		$I->comment("Entering Action Group [verifyBillingAddress] VerifyCustomerBillingAddressWithStateActionGroup");
		$I->amOnPage("customer/address/index/"); // stepKey: goToAddressPageVerifyBillingAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageLoadVerifyBillingAddress
		$I->comment("Verify customer default billing address");
		$I->see("John Doe", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressFirstnameAndLastnameVerifyBillingAddress
		$I->see("Magento", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressCompanyVerifyBillingAddress
		$I->see("Chaussee de Wavre", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressStreetVerifyBillingAddress
		$I->see("318", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressStreet1VerifyBillingAddress
		$I->see("Bihain, Hainaut, 6690", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressCityAndPostcodeVerifyBillingAddress
		$I->see("Belgium", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressCountryVerifyBillingAddress
		$I->see("0477-58-77867", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressTelephoneVerifyBillingAddress
		$I->comment("Exiting Action Group [verifyBillingAddress] VerifyCustomerBillingAddressWithStateActionGroup");
		$I->comment("Verify customer default shipping address");
		$I->comment("Entering Action Group [verifyShippingAddress] VerifyCustomerShippingAddressWithStateActionGroup");
		$I->amOnPage("customer/address/index/"); // stepKey: goToAddressPageVerifyShippingAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageLoadVerifyShippingAddress
		$I->comment("Verify customer default shipping address");
		$I->see("John Doe", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressFirstnameAndLastnameVerifyShippingAddress
		$I->see("Magento", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCompanyVerifyShippingAddress
		$I->see("Chaussee de Wavre", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressStreetVerifyShippingAddress
		$I->see("318", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressStreet1VerifyShippingAddress
		$I->see("Bihain, Hainaut, 6690", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCityAndPostcodeVerifyShippingAddress
		$I->see("Belgium", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCountryVerifyShippingAddress
		$I->see("0477-58-77867", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressTelephoneVerifyShippingAddress
		$I->comment("Exiting Action Group [verifyShippingAddress] VerifyCustomerShippingAddressWithStateActionGroup");
		$I->comment("Verify country Belgium can be saved without state as state not required");
		$I->comment("Entering Action Group [clickOnDefaultShippingAddress] StoreFrontClickEditDefaultShippingAddressActionGroup");
		$I->click("//div[@class='box-actions']//span[text()='Change Shipping Address']"); // stepKey: ClickEditDefaultShippingAddressClickOnDefaultShippingAddress
		$I->waitForPageLoad(30); // stepKey: ClickEditDefaultShippingAddressClickOnDefaultShippingAddressWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontSignInPageLoadClickOnDefaultShippingAddress
		$I->comment("Exiting Action Group [clickOnDefaultShippingAddress] StoreFrontClickEditDefaultShippingAddressActionGroup");
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'country_id')]", "Belgium"); // stepKey: selectCountry
		$I->selectOption("//form[@class='form-address-edit']//select[contains(@name, 'region_id')]", "Please select a region, state or province."); // stepKey: selectState
		$I->comment("Entering Action Group [saveAddress] AdminSaveCustomerAddressActionGroup");
		$I->click("//button[@title='Save Address']"); // stepKey: saveCustomerAddressSaveAddress
		$I->waitForPageLoad(30); // stepKey: saveCustomerAddressSaveAddressWaitForPageLoad
		$I->see("You saved the address.", "div.message-success.success.message"); // stepKey: seeSuccessMessageSaveAddress
		$I->comment("Exiting Action Group [saveAddress] AdminSaveCustomerAddressActionGroup");
		$I->see("Belgium", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCountry
	}
}
