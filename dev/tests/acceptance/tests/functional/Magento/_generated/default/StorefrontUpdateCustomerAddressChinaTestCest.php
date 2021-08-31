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
 * @Title("MC-20234: Update customer address on storefront with china address")
 * @Description("Update customer address on storefront with china address and verify you can select a region<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontUpdateCustomerAddressChinaTest.xml<br>")
 * @TestCaseId("MC-20234")
 * @group customer
 */
class StorefrontUpdateCustomerAddressChinaTestCest
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
	 * @Stories({"Update Regions list for China country"})
	 * @Severity(level = SeverityLevel::MINOR)
	 * @Features({"Customer"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontUpdateCustomerAddressChinaTest(AcceptanceTester $I)
	{
		$I->comment("Update customer address in storefront");
		$I->comment("Entering Action Group [enterAddress] EnterCustomerAddressInfoActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: goToAddressPageEnterAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageEnterAddress
		$I->fillField("#firstname", "Xian"); // stepKey: fillFirstNameEnterAddress
		$I->fillField("#lastname", "Shai"); // stepKey: fillLastNameEnterAddress
		$I->fillField("#company", "Hunan Fenmian"); // stepKey: fillCompanyEnterAddress
		$I->fillField("#telephone", "+86 851 8410 4337"); // stepKey: fillPhoneNumberEnterAddress
		$I->fillField("#street_1", "Nanyuan Rd, Wudang"); // stepKey: fillStreetAddress1EnterAddress
		$I->fillField("#street_2", "Hunan Fenmian"); // stepKey: fillStreetAddress2EnterAddress
		$I->fillField("#city", "Guiyang"); // stepKey: fillCityNameEnterAddress
		$I->selectOption("#country", "CN"); // stepKey: selectCountyEnterAddress
		$I->selectOption("#region_id", "Guizhou Sheng"); // stepKey: selectStateEnterAddress
		$I->fillField("#zip", "550002"); // stepKey: fillZipEnterAddress
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
		$I->see("Xian Shai", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressFirstnameAndLastnameVerifyBillingAddress
		$I->see("Hunan Fenmian", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressCompanyVerifyBillingAddress
		$I->see("Nanyuan Rd, Wudang", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressStreetVerifyBillingAddress
		$I->see("Hunan Fenmian", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressStreet1VerifyBillingAddress
		$I->see("Guiyang, Guizhou Sheng, 550002", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressCityAndPostcodeVerifyBillingAddress
		$I->see("China", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressCountryVerifyBillingAddress
		$I->see("+86 851 8410 4337", ".box-address-billing"); // stepKey: seeAssertCustomerDefaultBillingAddressTelephoneVerifyBillingAddress
		$I->comment("Exiting Action Group [verifyBillingAddress] VerifyCustomerBillingAddressWithStateActionGroup");
		$I->comment("Verify customer default shipping address");
		$I->comment("Entering Action Group [verifyShippingAddress] VerifyCustomerShippingAddressWithStateActionGroup");
		$I->amOnPage("customer/address/index/"); // stepKey: goToAddressPageVerifyShippingAddress
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageLoadVerifyShippingAddress
		$I->comment("Verify customer default shipping address");
		$I->see("Xian Shai", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressFirstnameAndLastnameVerifyShippingAddress
		$I->see("Hunan Fenmian", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCompanyVerifyShippingAddress
		$I->see("Nanyuan Rd, Wudang", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressStreetVerifyShippingAddress
		$I->see("Hunan Fenmian", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressStreet1VerifyShippingAddress
		$I->see("Guiyang, Guizhou Sheng, 550002", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCityAndPostcodeVerifyShippingAddress
		$I->see("China", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressCountryVerifyShippingAddress
		$I->see("+86 851 8410 4337", ".box-address-shipping"); // stepKey: seeAssertCustomerDefaultShippingAddressTelephoneVerifyShippingAddress
		$I->comment("Exiting Action Group [verifyShippingAddress] VerifyCustomerShippingAddressWithStateActionGroup");
	}
}
