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
 * @Title("MC-71: Admin should be able to apply the catalog rule by customer group")
 * @Description("Admin should be able to apply the catalog rule by customer group<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminCreateCatalogPriceRuleTest/AdminCreateCatalogPriceRuleForCustomerGroupTest.xml<br>")
 * @TestCaseId("MC-71")
 * @group CatalogRule
 */
class AdminCreateCatalogPriceRuleForCustomerGroupTestCest
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
		$I->comment("Create a simple product and a category");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogPriceRule
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRuleWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogPriceRule] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogPriceRule
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogPriceRule
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogPriceRule
		$I->comment("Exiting Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->comment("Adding the comment to replace AdminReindexAndFlushCache action group ('indexer:reindex', 'cache:flush' commands) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete the simple product and category");
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Entering Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToAdminCatalogPriceRuleGridPageDeleteAllCatalogPriceRule
		$I->comment("It sometimes is loading too long for default 10s");
		$I->waitForPageLoad(60); // stepKey: waitForPageFullyLoadedDeleteAllCatalogPriceRule
		$I->conditionalClick(".admin__data-grid-header [data-action='grid-filter-reset']", ".admin__data-grid-header [data-action='grid-filter-reset']", true); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clearExistingFiltersDeleteAllCatalogPriceRuleWaitForPageLoad
		$I->comment('[deleteAllRulesOneByOneDeleteAllCatalogPriceRule] Magento\Rule\Test\Mftf\Helper\RuleHelper::deleteAllRulesOneByOne()');
		$this->helperContainer->get('Magento\Rule\Test\Mftf\Helper\RuleHelper')->deleteAllRulesOneByOne("table.data-grid tbody tr[data-role=row]:not(.data-grid-tr-no-data):nth-of-type(1)", "aside.confirm .modal-footer button.action-accept", "#delete", "#messages div.message-success", "You deleted the rule."); // stepKey: deleteAllRulesOneByOneDeleteAllCatalogPriceRule
		$I->waitForElementVisible(".data-grid-tr-no-data td", 30); // stepKey: waitDataGridEmptyMessageAppearsDeleteAllCatalogPriceRule
		$I->see("We couldn't find any records.", ".data-grid-tr-no-data td"); // stepKey: assertDataGridEmptyMessageDeleteAllCatalogPriceRule
		$I->comment("Exiting Action Group [deleteAllCatalogPriceRule] AdminCatalogPriceRuleDeleteAllActionGroup");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$reindexInvalidatedIndices = $I->magentoCron("index", 90); // stepKey: reindexInvalidatedIndices
		$I->comment($reindexInvalidatedIndices);
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
	 * @Stories({"Apply catalog price rule"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCatalogPriceRuleForCustomerGroupTest(AcceptanceTester $I)
	{
		$I->comment("Create a catalog rule for the NOT LOGGED IN customer group");
		$I->comment("Entering Action Group [createNewPriceRule] NewCatalogPriceRuleByUIActionGroup");
		$I->comment("Go to the admin Catalog rule grid and add a new one");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageCreateNewPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageCreateNewPriceRule
		$I->click("#add"); // stepKey: addNewRuleCreateNewPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewRuleCreateNewPriceRuleWaitForPageLoad
		$I->comment("Fill the form according the attributes of the entity");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillNameCreateNewPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionCreateNewPriceRule
		$I->click("input[name='is_active']+label"); // stepKey: selectActiveCreateNewPriceRule
		$I->selectOption("[name='website_ids']", "1"); // stepKey: selectSiteCreateNewPriceRule
		$I->click("[name='from_date'] + button"); // stepKey: clickFromCalenderCreateNewPriceRule
		$I->waitForPageLoad(15); // stepKey: clickFromCalenderCreateNewPriceRuleWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickFromTodayCreateNewPriceRule
		$I->click("[name='to_date'] + button"); // stepKey: clickToCalenderCreateNewPriceRule
		$I->waitForPageLoad(15); // stepKey: clickToCalenderCreateNewPriceRuleWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickToTodayCreateNewPriceRule
		$I->click("[data-index='actions']"); // stepKey: openActionDropdownCreateNewPriceRule
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountValueCreateNewPriceRule
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: discountTypeCreateNewPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: discardSubsequentRulesCreateNewPriceRule
		$I->comment("Scroll to top and either save or save and apply after the action group");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopCreateNewPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAppliedCreateNewPriceRule
		$I->comment("Exiting Action Group [createNewPriceRule] NewCatalogPriceRuleByUIActionGroup");
		$I->comment("Entering Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectNotLoggedInCustomerGroup
		$I->comment("Exiting Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->conditionalClick("//div[contains(@class, 'admin__actions-switch')]/input[@name='is_active']/../label", "(//div[contains(@class, 'admin__actions-switch')])[1]/input[@value='1']", false); // stepKey: enableActiveBtn
		$I->click("#save_and_apply"); // stepKey: saveAndApply
		$I->waitForPageLoad(30); // stepKey: saveAndApplyWaitForPageLoad
		$I->comment("<click selector=\"\{\{AdminNewCatalogPriceRule.saveAndApply\}\}\" stepKey=\"saveAndApply\"/>");
		$I->see("You saved the rule.", ".message-success"); // stepKey: assertSuccess
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("As a NOT LOGGED IN user, go to the storefront category page and should see the discount");
		$I->comment("Entering Action Group [goToCategory1] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageGoToCategory1
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGoToCategory1
		$I->comment("Exiting Action Group [goToCategory1] StorefrontNavigateCategoryPageActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProduct1
		$I->see("$110.70", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeDiscountedPrice1
		$I->comment("Create a user account");
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
		$I->comment("As a logged in user, go to the storefront category page and should NOT see discount");
		$I->comment("Entering Action Group [goToCategory2] StorefrontNavigateCategoryPageActionGroup");
		$I->comment("Open category page on storefront");
		$I->amOnPage("/" . $I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateStorefrontCategoryPageGoToCategory2
		$I->waitForPageLoad(30); // stepKey: waitForCategoryPageLoadGoToCategory2
		$I->comment("Exiting Action Group [goToCategory2] StorefrontNavigateCategoryPageActionGroup");
		$I->see($I->retrieveEntityField('createProduct', 'name', 'test'), "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProduct2
		$I->see("$123.00", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeDiscountedPrice2
	}
}
