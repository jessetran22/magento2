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
 * @Title("MAGETWO-95028: Check tax adding when it's changed to 'Valid VAT ID - Intra-Union'")
 * @Description("Tax should be applied<h3>Test files</h3>app/code/Magento/Customer/Test/Mftf/Test/StorefrontCheckTaxAddingValidVATIdTest.xml<br>")
 * @TestCaseId("MAGETWO-95028")
 * @group customer
 */
class StorefrontCheckTaxAddingValidVATIdTestCest
{
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->comment("Log In");
		$I->comment("Entering Action Group [logIn] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogIn
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogIn
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogIn
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogIn
		$I->waitForPageLoad(30); // stepKey: clickLoginLogInWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogIn
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogIn
		$I->comment("Exiting Action Group [logIn] AdminLoginActionGroup");
		$I->comment("Create category");
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->comment("Create product");
		$I->createEntity("createProduct", "hook", "SimpleProduct", ["createCategory"], []); // stepKey: createProduct
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Go to the tax rule page and delete the row we created");
		$I->comment("Entering Action Group [goToTaxRulesPage] AdminTaxRuleGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRuleGridPageGoToTaxRulesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRulePageGoToTaxRulesPage
		$I->comment("Exiting Action Group [goToTaxRulesPage] AdminTaxRuleGridOpenPageActionGroup");
		$I->comment("Entering Action Group [deleteRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteRule
		$I->fillField(".col-code .admin__control-text", "TaxName" . msq("TaxRule")); // stepKey: fillIdentifierDeleteRule
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteRule
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteRule
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteRule
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteRuleWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteRule
		$I->comment("Exiting Action Group [deleteRule] deleteEntitySecondaryGrid");
		$I->comment("Entering Action Group [deleteSecondRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteSecondRule
		$I->fillField(".col-code .admin__control-text", "TaxNameZeroRate" . msq("TaxRuleZeroRate")); // stepKey: fillIdentifierDeleteSecondRule
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteSecondRule
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteSecondRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteSecondRule
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteSecondRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteSecondRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteSecondRule
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteSecondRuleWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteSecondRule
		$I->comment("Exiting Action Group [deleteSecondRule] deleteEntitySecondaryGrid");
		$I->comment("Go to the tax rate page");
		$I->comment("Entering Action Group [goToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rate/"); // stepKey: goToTaxRatePageGoToTaxRatesPage
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageGoToTaxRatesPage
		$I->comment("Exiting Action Group [goToTaxRatesPage] AdminTaxRateGridOpenPageActionGroup");
		$I->comment("Delete the two tax rates that were created");
		$I->comment("Entering Action Group [deleteNYRate] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteNYRate
		$I->fillField(".col-code .admin__control-text", "California-50"); // stepKey: fillIdentifierDeleteNYRate
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteNYRate
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteNYRate
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteNYRate
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteNYRate
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteNYRateWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteNYRate
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteNYRateWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteNYRate
		$I->comment("Exiting Action Group [deleteNYRate] deleteEntitySecondaryGrid");
		$I->comment("Entering Action Group [deleteCARate] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeleteCARate
		$I->fillField(".col-code .admin__control-text", "California-0"); // stepKey: fillIdentifierDeleteCARate
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeleteCARate
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeleteCARate
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeleteCARate
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeleteCARate
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeleteCARateWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeleteCARate
		$I->waitForPageLoad(60); // stepKey: clickOkDeleteCARateWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeleteCARate
		$I->comment("Exiting Action Group [deleteCARate] deleteEntitySecondaryGrid");
		$I->comment("Delete created customer group");
		$I->comment("Entering Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/"); // stepKey: goToAdminCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupIndexPageLoadDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: openFiltersSectionOnCustomerGroupIndexPageDeleteCustomerGroupWaitForPageLoad
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: cleanFiltersIfTheySetDeleteCustomerGroupWaitForPageLoad
		$I->fillField(".admin__data-grid-filters input[name='customer_group_code']", "test_UK"); // stepKey: fillNameFieldOnFiltersSectionDeleteCustomerGroup
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='test_UK']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//button[text()='Select']"); // stepKey: clickSelectButtonDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickSelectButtonDeleteCustomerGroupWaitForPageLoad
		$I->click("//div[text()='test_UK']/parent::td//following-sibling::td[@class='data-grid-actions-cell']//a[text()='Delete']"); // stepKey: clickOnDeleteItemDeleteCustomerGroup
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteItemDeleteCustomerGroupWaitForPageLoad
		$I->waitForElementVisible(".modal-popup.confirm div.modal-content", 30); // stepKey: waitForConfirmModalDeleteCustomerGroup
		$I->see("Are you sure you want to delete a test_UK record?", ".modal-popup.confirm div.modal-content"); // stepKey: seeRemoveMessageDeleteCustomerGroup
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroup
		$I->waitForPageLoad(60); // stepKey: confirmDeleteCustomerGroupDeleteCustomerGroupWaitForPageLoad
		$I->seeElement("#messages div.message-success"); // stepKey: seeSuccessMessageDeleteCustomerGroup
		$I->comment("Exiting Action Group [deleteCustomerGroup] AdminDeleteCustomerGroupActionGroup");
		$I->createEntity("setCustomerCreateNewAccountOptionsDefaultConfig", "hook", "SetCustomerCreateNewAccountOptionsDefaultConfig", [], []); // stepKey: setCustomerCreateNewAccountOptionsDefaultConfig
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategoryFirst
		$I->comment("Entering Action Group [deleteFirstProductTaxClass] DeleteProductTaxClassActionGroup");
		$I->comment("Go to tax rule page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule/new/"); // stepKey: goToNewTaxRulePageDeleteFirstProductTaxClass
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageDeleteFirstProductTaxClass
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettingsDeleteFirstProductTaxClass
		$I->scrollTo("#details-summarybase_fieldset"); // stepKey: scrollToAdditionalSettingsDeleteFirstProductTaxClass
		$I->moveMouseOver("//span[contains(text(),'UK_zero')]"); // stepKey: hoverDeleteElementDeleteFirstProductTaxClass
		$I->click("//span[contains(text(),'UK_zero')]/../..//*[@class='mselect-delete']"); // stepKey: deleteFirstTaxClassDeleteFirstProductTaxClass
		$I->waitForElementVisible("//*[@class='modal-footer']//*[contains(text(),'OK')]", 30); // stepKey: waitForElementBecomeVisibleDeleteFirstProductTaxClass
		$I->click("//*[@class='modal-footer']//*[contains(text(),'OK')]"); // stepKey: acceptPopUpDialogDeleteFirstProductTaxClass
		$I->waitForPageLoad(30); // stepKey: waitForProductTaxClassDeletedDeleteFirstProductTaxClass
		$I->comment("Exiting Action Group [deleteFirstProductTaxClass] DeleteProductTaxClassActionGroup");
		$I->comment("Log Out");
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
	 * @Stories({"MAGETWO-91639: Tax is added despite customer group changes"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckTaxAddingValidVATIdTest(AcceptanceTester $I)
	{
		$I->comment("Add new tax rates. Go to tax rule page");
		$I->comment("Entering Action Group [addFirstTaxRuleActionGroup] AddNewTaxRuleActionGroup");
		$I->comment("Go to tax rule page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRulePageAddFirstTaxRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageAddFirstTaxRuleActionGroup
		$I->click("#add"); // stepKey: addNewTaxRateAddFirstTaxRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateAddFirstTaxRuleActionGroupWaitForPageLoad
		$I->comment("Exiting Action Group [addFirstTaxRuleActionGroup] AddNewTaxRuleActionGroup");
		$I->fillField("#anchor-content #code", "TaxName" . msq("TaxRule")); // stepKey: fillRuleName
		$I->comment("Add NY and CA tax rules");
		$I->comment("Entering Action Group [addSimpleTaxUK] AddNewTaxRateNoZipActionGroup");
		$I->comment("Go to the tax rate page");
		$I->click("//*[text()='Add New Tax Rate']"); // stepKey: addNewTaxRateAddSimpleTaxUK
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateAddSimpleTaxUKWaitForPageLoad
		$I->comment("Fill out a new tax rate");
		$I->fillField("aside #code", "California-50"); // stepKey: fillTaxIdentifierAddSimpleTaxUK
		$I->fillField("#tax_postcode", "*"); // stepKey: fillZipCodeAddSimpleTaxUK
		$I->selectOption("#tax_region_id", "California"); // stepKey: selectStateAddSimpleTaxUK
		$I->selectOption("#tax_country_id", "United Kingdom"); // stepKey: selectCountryAddSimpleTaxUK
		$I->fillField("#rate", "50"); // stepKey: fillRateAddSimpleTaxUK
		$I->comment("Save the tax rate");
		$I->click(".action-save"); // stepKey: saveTaxRateAddSimpleTaxUK
		$I->waitForPageLoad(30); // stepKey: saveTaxRateAddSimpleTaxUKWaitForPageLoad
		$I->comment("Exiting Action Group [addSimpleTaxUK] AddNewTaxRateNoZipActionGroup");
		$I->click("#save"); // stepKey: clickSave
		$I->waitForPageLoad(90); // stepKey: clickSaveWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForNewTaxRuleCreated
		$I->comment("Go to tax rule page to create second Tax Rule");
		$I->comment("Entering Action Group [addSecondTaxRuleActionGroup] AddNewTaxRuleActionGroup");
		$I->comment("Go to tax rule page");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/tax/rule"); // stepKey: goToTaxRulePageAddSecondTaxRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForTaxRatePageAddSecondTaxRuleActionGroup
		$I->click("#add"); // stepKey: addNewTaxRateAddSecondTaxRuleActionGroup
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateAddSecondTaxRuleActionGroupWaitForPageLoad
		$I->comment("Exiting Action Group [addSecondTaxRuleActionGroup] AddNewTaxRuleActionGroup");
		$I->fillField("#anchor-content #code", "TaxNameZeroRate" . msq("TaxRuleZeroRate")); // stepKey: fillSecondRuleName
		$I->comment("Entering Action Group [addSimpleTaxUKZeroRate] AddNewTaxRateNoZipActionGroup");
		$I->comment("Go to the tax rate page");
		$I->click("//*[text()='Add New Tax Rate']"); // stepKey: addNewTaxRateAddSimpleTaxUKZeroRate
		$I->waitForPageLoad(30); // stepKey: addNewTaxRateAddSimpleTaxUKZeroRateWaitForPageLoad
		$I->comment("Fill out a new tax rate");
		$I->fillField("aside #code", "California-0"); // stepKey: fillTaxIdentifierAddSimpleTaxUKZeroRate
		$I->fillField("#tax_postcode", "*"); // stepKey: fillZipCodeAddSimpleTaxUKZeroRate
		$I->selectOption("#tax_region_id", "California"); // stepKey: selectStateAddSimpleTaxUKZeroRate
		$I->selectOption("#tax_country_id", "United Kingdom"); // stepKey: selectCountryAddSimpleTaxUKZeroRate
		$I->fillField("#rate", "0"); // stepKey: fillRateAddSimpleTaxUKZeroRate
		$I->comment("Save the tax rate");
		$I->click(".action-save"); // stepKey: saveTaxRateAddSimpleTaxUKZeroRate
		$I->waitForPageLoad(30); // stepKey: saveTaxRateAddSimpleTaxUKZeroRateWaitForPageLoad
		$I->comment("Exiting Action Group [addSimpleTaxUKZeroRate] AddNewTaxRateNoZipActionGroup");
		$I->comment("Entering Action Group [addCustomerTaxClass] AddCustomerTaxClassActionGroup");
		$I->comment("Click Additional Settings");
		$I->click("#details-summarybase_fieldset"); // stepKey: clickAdditionalSettingsAddCustomerTaxClass
		$I->comment("Click Product Add New Tax Class Button");
		$I->click("//*[@id='tax_customer_class']/following-sibling::section//*[contains(text(),'Add New Tax Class')]"); // stepKey: clickCustomerAddNewTaxClassBtnAddCustomerTaxClass
		$I->comment("Fill field");
		$I->fillField("//*[@id='tax_customer_class']/following-sibling::section//input[@class='mselect-input']", "UK_zero"); // stepKey: fillCustomerNewTaxClassAddCustomerTaxClass
		$I->comment("Save Product tax rate");
		$I->click("//*[@id='tax_customer_class']/following-sibling::section//span[@class='mselect-save']"); // stepKey: saveProdTaxRateAddCustomerTaxClass
		$I->comment("Exiting Action Group [addCustomerTaxClass] AddCustomerTaxClassActionGroup");
		$I->click("//*[@id='tax_customer_class']/following-sibling::section//div[@class='mselect-items-wrapper']/div[1]"); // stepKey: disableDefaultProdTaxClass
		$I->wait(2); // stepKey: waitForDisableDefaultProdTaxClass
		$I->click("#save"); // stepKey: clickSaveBtn
		$I->waitForPageLoad(90); // stepKey: clickSaveBtnWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForSecondTaxRuleCreated
		$I->comment("Create a Customer Group (CUSTOMERS > Customer Groups)");
		$I->comment("Entering Action Group [createCustomerGroup] AdminCreateCustomerGroupActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/customer/group/new/"); // stepKey: goToNewCustomerGroupPageCreateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForNewCustomerGroupPageLoadCreateCustomerGroup
		$I->comment("Set tax class for customer group");
		$I->fillField("#customer_group_code", "test_UK"); // stepKey: fillGroupNameCreateCustomerGroup
		$I->selectOption("#tax_class_id", "UK_zero"); // stepKey: selectTaxClassOptionCreateCustomerGroup
		$I->click("#save"); // stepKey: clickToSaveCustomerGroupCreateCustomerGroup
		$I->waitForPageLoad(30); // stepKey: waitForCustomerGroupSavedCreateCustomerGroup
		$I->see("You saved the customer group."); // stepKey: seeCustomerGroupSaveMessageCreateCustomerGroup
		$I->comment("Exiting Action Group [createCustomerGroup] AdminCreateCustomerGroupActionGroup");
		$I->comment("Set Customer Create New Account Options Config");
		$I->createEntity("setCustomerCreateNewAccountOptionsConfig", "test", "SetCustomerCreateNewAccountOptionsConfig", [], []); // stepKey: setCustomerCreateNewAccountOptionsConfig
		$I->comment("Entering Action Group [setGroupForValidVATIdIntraUnionActionGroup] SetGroupForValidVATIdIntraUnionActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/system_config/edit/section/customer/"); // stepKey: navigateToCustomerConfigurationPageSetGroupForValidVATIdIntraUnionActionGroup
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSetGroupForValidVATIdIntraUnionActionGroup
		$I->conditionalClick("#customer_create_account-head", "#customer_create_account_auto_group_assign", false); // stepKey: expandCreateNewAccountOptionsTabSetGroupForValidVATIdIntraUnionActionGroup
		$I->waitForElementVisible("#customer_create_account-head", 30); // stepKey: waitForElementsAppearedSetGroupForValidVATIdIntraUnionActionGroup
		$I->selectOption("#customer_create_account_viv_intra_union_group", "test_UK"); // stepKey: selectValueSetGroupForValidVATIdIntraUnionActionGroup
		$I->click("#customer_create_account-head"); // stepKey: collapseTabSetGroupForValidVATIdIntraUnionActionGroup
		$I->click("#save"); // stepKey: saveConfigSetGroupForValidVATIdIntraUnionActionGroup
		$I->waitForPageLoad(30); // stepKey: saveConfigSetGroupForValidVATIdIntraUnionActionGroupWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForConfigSavedSetGroupForValidVATIdIntraUnionActionGroup
		$I->see("You saved the configuration."); // stepKey: seeSuccessMessageSetGroupForValidVATIdIntraUnionActionGroup
		$I->comment("Exiting Action Group [setGroupForValidVATIdIntraUnionActionGroup] SetGroupForValidVATIdIntraUnionActionGroup");
		$I->comment("Register customer on storefront");
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
		$I->comment("Go to My account > Address book");
		$I->comment("Entering Action Group [enterAddressInfo] EnterCustomerAddressInfoFillStateActionGroup");
		$I->amOnPage("customer/address/new/"); // stepKey: goToAddressPageEnterAddressInfo
		$I->waitForPageLoad(30); // stepKey: waitForAddressPageEnterAddressInfo
		$I->fillField("#firstname", "Jane"); // stepKey: fillFirstNameEnterAddressInfo
		$I->fillField("#lastname", "Doe"); // stepKey: fillLastNameEnterAddressInfo
		$I->fillField("#company", "Magento"); // stepKey: fillCompanyEnterAddressInfo
		$I->fillField("#telephone", "444-44-444-44"); // stepKey: fillPhoneNumberEnterAddressInfo
		$I->fillField("#street_1", "172, Westminster Bridge Rd"); // stepKey: fillStreetAddress1EnterAddressInfo
		$I->fillField("#street_2", "7700 xyz street"); // stepKey: fillStreetAddress2EnterAddressInfo
		$I->fillField("#city", "London"); // stepKey: fillCityNameEnterAddressInfo
		$I->selectOption("#country", "GB"); // stepKey: selectCountyEnterAddressInfo
		$I->fillField("#region", "California"); // stepKey: selectStateEnterAddressInfo
		$I->fillField("#zip", "SE1 7RW"); // stepKey: fillZipEnterAddressInfo
		$I->click("[data-action='save-address']"); // stepKey: saveAddressEnterAddressInfo
		$I->waitForPageLoad(30); // stepKey: saveAddressEnterAddressInfoWaitForPageLoad
		$I->comment("Exiting Action Group [enterAddressInfo] EnterCustomerAddressInfoFillStateActionGroup");
		$I->comment("Go to product visible");
		$I->amOnPage($I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPageOnDefaultStore
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), ".base"); // stepKey: assertFirstProductNameTitle
		$I->comment("Add a product to the cart");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Proceed to checkout");
		$I->comment("Entering Action Group [GoToCheckoutFromMinicartActionGroup] GoToCheckoutFromMinicartActionGroup");
		$I->waitForElementNotVisible(".counter.qty.empty", 30); // stepKey: waitUpdateQuantityGoToCheckoutFromMinicartActionGroup
		$I->wait(5); // stepKey: waitMinicartRenderingGoToCheckoutFromMinicartActionGroup
		$I->click("a.showcart"); // stepKey: clickCartGoToCheckoutFromMinicartActionGroup
		$I->waitForPageLoad(60); // stepKey: clickCartGoToCheckoutFromMinicartActionGroupWaitForPageLoad
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckoutGoToCheckoutFromMinicartActionGroup
		$I->waitForPageLoad(30); // stepKey: goToCheckoutGoToCheckoutFromMinicartActionGroupWaitForPageLoad
		$I->comment("Exiting Action Group [GoToCheckoutFromMinicartActionGroup] GoToCheckoutFromMinicartActionGroup");
		$I->comment("Click next button to open payment section");
		$I->comment("Entering Action Group [clickNext] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->click("button.button.action.continue.primary"); // stepKey: clickNextClickNext
		$I->waitForPageLoad(30); // stepKey: clickNextClickNextWaitForPageLoad
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoadedClickNext
		$I->seeInCurrentUrl("/checkout/#payment"); // stepKey: assertCheckoutPaymentUrlClickNext
		$I->comment("Exiting Action Group [clickNext] StorefrontGuestCheckoutProceedToPaymentStepActionGroup");
		$I->comment("Comment is added to preserve the step key for backward compatibility");
		$I->comment("Check order summary in checkout");
		$I->waitForElement("//*[@id='checkout-payment-method-load']//div[@data-role='title']", 30); // stepKey: waitForPaymentSectionLoaded
		$I->comment("Verify that Tax 50% is applied");
		$I->see("$123.00", "//tr[@class='totals sub']//span[@class='price']"); // stepKey: assertSubtotal
		$I->see("$5.00", "//tr[@class='totals shipping excl']//span[@class='price']"); // stepKey: assertShipping
		$I->see("Flat Rate - Fixed", "//tr[@class='totals shipping excl']//span[@class='value']"); // stepKey: assertShippingMethod
		$I->see("$61.50", "[data-th='Tax'] span"); // stepKey: assertTax
		$I->waitForPageLoad(30); // stepKey: assertTaxWaitForPageLoad
		$I->see("$189.50", "//tr[@class='grand totals']//span[@class='price']"); // stepKey: assertTotal
	}
}
