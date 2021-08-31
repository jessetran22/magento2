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
 * @Title("MC-27571: Verify that Catalog Price Rule and Customer Group Membership are persisted under long-term cookie")
 * @Description("Verify that Catalog Price Rule and Customer Group Membership are persisted under long-term cookie<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/CatalogPriceRuleAndCustomerGroupMembershipArePersistedUnderLongTermCookieTest.xml<br>")
 * @TestCaseId("MC-27571")
 * @group persistent
 */
class CatalogPriceRuleAndCustomerGroupMembershipArePersistedUnderLongTermCookieTestCest
{
    /**
     * @var \Magento\FunctionalTestingFramework\Helper\HelperContainer
     */
    private $helperContainer;

    /**
     * Special method which automatically creates the respective objects.
     */
    public function _inject(\Magento\FunctionalTestingFramework\Helper\HelperContainer $helperContainer)
    {
        $this->helperContainer = $helperContainer;
        $this->helperContainer->create("Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Catalog\Test\Mftf\Helper\LocalFileAssertions");
        $this->helperContainer->create("\Magento\Backend\Test\Mftf\Helper\CurlHelpers");
        $this->helperContainer->create("Magento\Rule\Test\Mftf\Helper\RuleHelper");
    }
	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _before(AcceptanceTester $I)
	{
		$I->createEntity("enablePersistent", "hook", "PersistentConfigSettings", [], []); // stepKey: enablePersistent
		$I->createEntity("createCategory", "hook", "_defaultCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "productWithHTMLEntityOne", ["createCategory"], []); // stepKey: createProduct
		$I->createEntity("createCustomer", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->comment("Create Catalog Rule");
		$I->comment("Entering Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageStartCreatingFirstPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStartCreatingFirstPriceRule
		$I->comment("Exiting Action Group [startCreatingFirstPriceRule] AdminOpenNewCatalogPriceRuleFormPageActionGroup");
		$I->comment("Entering Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameFillMainInfoForFirstPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionFillMainInfoForFirstPriceRule
		$I->conditionalClick("input[name='is_active']+label", "div.admin__actions-switch input[name='is_active'][value='1']+label", false); // stepKey: fillActiveFillMainInfoForFirstPriceRule
		$I->selectOption("[name='website_ids']", ['Main Website']); // stepKey: selectSpecifiedWebsitesFillMainInfoForFirstPriceRule
		$I->selectOption("[name='customer_group_ids']", ['General']); // stepKey: selectSpecifiedCustomerGroupsFillMainInfoForFirstPriceRule
		$I->fillField("[name='from_date']", ""); // stepKey: fillFromDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='to_date']", ""); // stepKey: fillToDateFillMainInfoForFirstPriceRule
		$I->fillField("[name='sort_order']", ""); // stepKey: fillPriorityFillMainInfoForFirstPriceRule
		$I->comment("Exiting Action Group [fillMainInfoForFirstPriceRule] AdminCatalogPriceRuleFillMainInfoActionGroup");
		$I->comment("Entering Action Group [createCatalogPriceRule] AdminFillCatalogRuleConditionActionGroup");
		$I->conditionalClick("[data-index='block_promo_catalog_edit_tab_conditions']", ".rule-param.rule-param-new-child", false); // stepKey: openConditionsTabCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: openConditionsTabCreateCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible(".rule-param.rule-param-new-child", 30); // stepKey: waitForAddConditionButtonCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAddConditionButtonCreateCatalogPriceRuleWaitForPageLoad
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewConditionCreateCatalogPriceRuleWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", "Magento\CatalogRule\Model\Rule\Condition\Product|category_ids"); // stepKey: selectTypeConditionCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionCreateCatalogPriceRuleWaitForPageLoad
		$I->click("//span[@class='rule-param']/a[text()='is']"); // stepKey: clickOnOperatorCreateCatalogPriceRule
		$I->selectOption(".rule-param-edit select[name*='[operator]']", "is"); // stepKey: selectConditionCreateCatalogPriceRule
		$I->comment("In case we are choosing already selected value - select is not closed automatically");
		$I->conditionalClick("//span[@class='rule-param']/a[text()='...']", ".rule-param-edit select[name*='[operator]']", true); // stepKey: closeSelectCreateCatalogPriceRule
		$I->click("//span[@class='rule-param']/a[text()='...']"); // stepKey: clickToChooseOption3CreateCatalogPriceRule
		$I->waitForElementVisible(".rule-param-edit [name*='[value]']", 30); // stepKey: waitForValueInputCreateCatalogPriceRule
		$I->fillField(".rule-param-edit [name*='[value]']", $I->retrieveEntityField('createCategory', 'id', 'hook')); // stepKey: fillConditionValueCreateCatalogPriceRule
		$I->click(".rule-param-edit .rule-param-apply"); // stepKey: clickApplyCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickApplyCreateCatalogPriceRuleWaitForPageLoad
		$I->waitForElementNotVisible(".rule-param-edit .rule-param-apply", 30); // stepKey: waitForApplyButtonInvisibilityCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForApplyButtonInvisibilityCreateCatalogPriceRuleWaitForPageLoad
		$I->comment("Exiting Action Group [createCatalogPriceRule] AdminFillCatalogRuleConditionActionGroup");
		$I->comment("Entering Action Group [fillActionsForThirdPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->conditionalClick("[data-index='actions'] .fieldset-wrapper-title", "[data-index='actions'] .admin__fieldset-wrapper-content", false); // stepKey: openActionSectionIfNeededFillActionsForThirdPriceRule
		$I->scrollTo("[data-index='actions'] .fieldset-wrapper-title"); // stepKey: scrollToActionsFieldsetFillActionsForThirdPriceRule
		$I->waitForElementVisible("[name='simple_action']", 30); // stepKey: waitActionsFieldsetFullyOpenedFillActionsForThirdPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: fillDiscountTypeFillActionsForThirdPriceRule
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountAmountFillActionsForThirdPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: fillDiscardSubsequentRulesFillActionsForThirdPriceRule
		$I->comment("Exiting Action Group [fillActionsForThirdPriceRule] AdminCatalogPriceRuleFillActionsActionGroup");
		$I->comment("Entering Action Group [clickSaveAndApplyRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopClickSaveAndApplyRule
		$I->waitForElementVisible("#save_and_apply", 30); // stepKey: waitForSaveAndApplyButtonClickSaveAndApplyRule
		$I->waitForPageLoad(30); // stepKey: waitForSaveAndApplyButtonClickSaveAndApplyRuleWaitForPageLoad
		$I->click("#save_and_apply"); // stepKey: saveAndApplyRuleClickSaveAndApplyRule
		$I->waitForPageLoad(30); // stepKey: saveAndApplyRuleClickSaveAndApplyRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageAppearsClickSaveAndApplyRule
		$I->see("You saved the rule.", "#messages div.message-success"); // stepKey: checkSuccessSaveMessageClickSaveAndApplyRule
		$I->see("Updated rules applied.", "#messages div.message-success"); // stepKey: checkSuccessAppliedMessageClickSaveAndApplyRule
		$I->comment("Exiting Action Group [clickSaveAndApplyRule] AdminCatalogPriceRuleSaveAndApplyActionGroup");
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->createEntity("setDefaultPersistentState", "hook", "PersistentConfigDefault", [], []); // stepKey: setDefaultPersistentState
		$I->createEntity("persistentLogoutClearEnabled", "hook", "PersistentLogoutClearEnabled", [], []); // stepKey: persistentLogoutClearEnabled
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCustomer", "hook"); // stepKey: deleteCustomer
		$I->comment("Delete the rule");
		$I->comment("Entering Action Group [deleteCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAdminCatalogPriceRuleGridPageLoadDeleteCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteCatalogPriceRuleWaitForPageLoad
		$I->fillField("#promo_catalog_grid_filter_name", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: filterByRuleNameDeleteCatalogPriceRule
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickSearchDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSearchDeleteCatalogPriceRuleWaitForPageLoad
		$I->click("table.data-grid tbody tr[data-role=row]:nth-of-type(1)"); // stepKey: clickEditDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteCatalogPriceRule
		$I->click("#delete"); // stepKey: clickToDeleteDeleteCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickToDeleteDeleteCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("aside.confirm .modal-footer button.action-accept", 30); // stepKey: waitForElementVisibleDeleteCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: waitForElementVisibleDeleteCatalogPriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickToConfirmDeleteCatalogPriceRule
		$I->waitForPageLoad(60); // stepKey: clickToConfirmDeleteCatalogPriceRuleWaitForPageLoad
		$I->waitForElementVisible("#messages div.message-success", 30); // stepKey: waitForSuccessMessageDeleteCatalogPriceRule
		$I->see("You deleted the rule.", "#messages div.message-success"); // stepKey: verifyRuleIsDeletedDeleteCatalogPriceRule
		$I->comment("Exiting Action Group [deleteCatalogPriceRule] RemoveCatalogPriceRuleActionGroup");
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
	 * @Features({"CatalogRule"})
	 * @Stories({"Check the price"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function CatalogPriceRuleAndCustomerGroupMembershipArePersistedUnderLongTermCookieTest(AcceptanceTester $I)
	{
		$I->comment("Go to category and check price");
		$I->comment("Entering Action Group [assertProductPriceInCategoryPage] AssertStorefrontProductPriceInCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPageAssertProductPriceInCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssertProductPriceInCategoryPage
		$I->see("50.00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductPriceInCategoryPage
		$I->comment("Exiting Action Group [assertProductPriceInCategoryPage] AssertStorefrontProductPriceInCategoryPageActionGroup");
		$I->comment("Login to storefront from customer and check price");
		$I->comment("Entering Action Group [logInFromCustomer] LoginToStorefrontActionGroup");
		$I->amOnPage("/customer/account/login/"); // stepKey: amOnSignInPageLogInFromCustomer
		$I->waitForPageLoad(30); // stepKey: waitPageFullyLoadedLogInFromCustomer
		$I->waitForElementVisible("#email", 30); // stepKey: waitFormAppearsLogInFromCustomer
		$I->fillField("#email", $I->retrieveEntityField('createCustomer', 'email', 'test')); // stepKey: fillEmailLogInFromCustomer
		$I->fillField("#pass", $I->retrieveEntityField('createCustomer', 'password', 'test')); // stepKey: fillPasswordLogInFromCustomer
		$I->click("#send2"); // stepKey: clickSignInAccountButtonLogInFromCustomer
		$I->waitForPageLoad(30); // stepKey: clickSignInAccountButtonLogInFromCustomerWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForCustomerLoggedInLogInFromCustomer
		$I->comment("Exiting Action Group [logInFromCustomer] LoginToStorefrontActionGroup");
		$I->comment("Entering Action Group [seeWelcomeMessageForJohnDoeCustomer] AssertCustomerWelcomeMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSeeWelcomeMessageForJohnDoeCustomer
		$I->see("Welcome, John Doe!", "header>.panel .greet.welcome"); // stepKey: verifyMessageSeeWelcomeMessageForJohnDoeCustomer
		$I->comment("Exiting Action Group [seeWelcomeMessageForJohnDoeCustomer] AssertCustomerWelcomeMessageActionGroup");
		$I->comment("Go to category and check special price");
		$I->comment("Entering Action Group [assertProductSpecialPriceInCategoryPage] AssertStorefrontProductSpecialPriceInCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPageAssertProductSpecialPriceInCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssertProductSpecialPriceInCategoryPage
		$I->see("50.00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductSpecialPriceInCategoryPage
		$I->see("45.00", "//div[contains(@class, 'product-item-info')][.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='special-price']/span"); // stepKey: assertProductSpecialPriceAssertProductSpecialPriceInCategoryPage
		$I->comment("Exiting Action Group [assertProductSpecialPriceInCategoryPage] AssertStorefrontProductSpecialPriceInCategoryPageActionGroup");
		$I->comment("Click *Sign Out*");
		$I->comment("Entering Action Group [storefrontSignOut] StorefrontSignOutActionGroup");
		$I->click(".customer-name"); // stepKey: clickCustomerButtonStorefrontSignOut
		$I->click("div.customer-menu  li.authorization-link"); // stepKey: clickToSignOutStorefrontSignOut
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadStorefrontSignOut
		$I->see("You are signed out"); // stepKey: signOutStorefrontSignOut
		$I->comment("Exiting Action Group [storefrontSignOut] StorefrontSignOutActionGroup");
		$I->comment("Entering Action Group [seeWelcomeForJohnDoeCustomer] StorefrontAssertPersistentCustomerWelcomeMessageActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadSeeWelcomeForJohnDoeCustomer
		$I->see("Welcome, John Doe! Not you?", "header>.panel .greet.welcome"); // stepKey: verifyMessageSeeWelcomeForJohnDoeCustomer
		$I->comment("Exiting Action Group [seeWelcomeForJohnDoeCustomer] StorefrontAssertPersistentCustomerWelcomeMessageActionGroup");
		$I->comment("Go to category and check special price");
		$I->comment("Entering Action Group [assertProductSpecialPriceInCategoryPageAfterLogout] AssertStorefrontProductSpecialPriceInCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPageAssertProductSpecialPriceInCategoryPageAfterLogout
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssertProductSpecialPriceInCategoryPageAfterLogout
		$I->see("50.00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductSpecialPriceInCategoryPageAfterLogout
		$I->see("45.00", "//div[contains(@class, 'product-item-info')][.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='special-price']/span"); // stepKey: assertProductSpecialPriceAssertProductSpecialPriceInCategoryPageAfterLogout
		$I->comment("Exiting Action Group [assertProductSpecialPriceInCategoryPageAfterLogout] AssertStorefrontProductSpecialPriceInCategoryPageActionGroup");
		$I->comment("Click the *Not you?* link and check the price for Simple Product");
		$I->click(".greet.welcome span a"); // stepKey: clickNotYouLink
		$I->comment("Entering Action Group [seeWelcomeMessageForJohnDoeCustomerAfterLogout] AssertStorefrontDefaultWelcomeMessageActionGroup");
		$I->waitForElementVisible("header>.panel .greet.welcome", 30); // stepKey: waitDefaultMessageSeeWelcomeMessageForJohnDoeCustomerAfterLogout
		$I->see("Default welcome msg!", "header>.panel .greet.welcome"); // stepKey: verifyDefaultMessageSeeWelcomeMessageForJohnDoeCustomerAfterLogout
		$I->dontSeeElement(".greet.welcome span a"); // stepKey: checkAbsenceLinkNotYouSeeWelcomeMessageForJohnDoeCustomerAfterLogout
		$I->comment("Exiting Action Group [seeWelcomeMessageForJohnDoeCustomerAfterLogout] AssertStorefrontDefaultWelcomeMessageActionGroup");
		$I->comment("Entering Action Group [assertProductPriceInCategoryPageAfterLogout] AssertStorefrontProductPriceInCategoryPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToCategoryPageAssertProductPriceInCategoryPageAfterLogout
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadAssertProductPriceInCategoryPageAfterLogout
		$I->see("50.00", "//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: assertProductPriceAssertProductPriceInCategoryPageAfterLogout
		$I->comment("Exiting Action Group [assertProductPriceInCategoryPageAfterLogout] AssertStorefrontProductPriceInCategoryPageActionGroup");
		$I->dontSeeElement("//div[contains(@class, 'product-item-info')][.//a[contains(text(), '" . $I->retrieveEntityField('createProduct', 'name', 'test') . "')]]//span[@class='special-price']/span"); // stepKey: dontSeeSpecialPrice
	}
}
