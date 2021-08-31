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
 * @Title("MC-74: Admin should be able to apply the catalog rule by category")
 * @Description("Admin should be able to apply the catalog rule by category<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminApplyCatalogRuleByCategoryTest.xml<br>")
 * @TestCaseId("MC-74")
 * @group CatalogRule
 */
class AdminApplyCatalogRuleByCategoryTestCest
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
		$I->createEntity("createCategoryOne", "hook", "ApiCategory", [], []); // stepKey: createCategoryOne
		$I->createEntity("createSimpleProductOne", "hook", "ApiSimpleProduct", ["createCategoryOne"], []); // stepKey: createSimpleProductOne
		$I->createEntity("createCategoryTwo", "hook", "ApiCategory", [], []); // stepKey: createCategoryTwo
		$I->createEntity("createSimpleProductTwo", "hook", "ApiSimpleProduct", ["createCategoryTwo"], []); // stepKey: createSimpleProductTwo
		$runCronIndex = $I->magentoCron("index", 90); // stepKey: runCronIndex
		$I->comment($runCronIndex);
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->deleteEntity("createCategoryOne", "hook"); // stepKey: deleteCategoryOne
		$I->deleteEntity("createSimpleProductOne", "hook"); // stepKey: deleteSimpleProductOne
		$I->deleteEntity("createCategoryTwo", "hook"); // stepKey: deleteCategoryTwo
		$I->deleteEntity("createSimpleProductTwo", "hook"); // stepKey: deleteSimpleProductTwo
		$I->comment("Delete the catalog price rule");
		$I->comment("Entering Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToPriceRulePage
		$I->comment("Exiting Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule
		$I->fillField(".col-name .admin__control-text", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillIdentifierDeletePriceRule
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeletePriceRule
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeletePriceRule
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeletePriceRule
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeletePriceRule
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeletePriceRuleWaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeletePriceRule
		$I->waitForPageLoad(60); // stepKey: clickOkDeletePriceRuleWaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeletePriceRule
		$I->comment("Exiting Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("Entering Action Group [amOnLogoutPage] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageAmOnLogoutPage
		$I->comment("Exiting Action Group [amOnLogoutPage] AdminLogoutActionGroup");
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
	 * @Severity(level = SeverityLevel::BLOCKER)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminApplyCatalogRuleByCategoryTest(AcceptanceTester $I)
	{
		$I->comment("1. Begin creating a new catalog price rule");
		$I->comment("Entering Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToPriceRulePage
		$I->comment("Exiting Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->click("#add"); // stepKey: addNewRule
		$I->waitForPageLoad(30); // stepKey: addNewRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForIndividualRulePage
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("_defaultCatalogRule")); // stepKey: fillName
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescription
		$I->click("input[name='is_active']+label"); // stepKey: selectActive
		$I->selectOption("[name='website_ids']", "1"); // stepKey: selectSite
		$I->click("[name='from_date'] + button"); // stepKey: clickFromCalender
		$I->waitForPageLoad(15); // stepKey: clickFromCalenderWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickFromToday
		$I->click("[name='to_date'] + button"); // stepKey: clickToCalender
		$I->waitForPageLoad(15); // stepKey: clickToCalenderWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickToToday
		$I->click("[data-index='block_promo_catalog_edit_tab_conditions']"); // stepKey: openConditions
		$I->click(".rule-param.rule-param-new-child"); // stepKey: clickNewRule
		$I->waitForPageLoad(30); // stepKey: clickNewRuleWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", "Category"); // stepKey: selectCategory
		$I->waitForPageLoad(30); // stepKey: selectCategoryWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForEllipsis
		$I->click("//li[1]//a[@class='label'][text() = '...']"); // stepKey: clickEllipsis
		$I->waitForPageLoad(30); // stepKey: waitForInput
		$I->comment("2. Fill condition of category = createCategoryOne");
		$I->fillField("input#conditions__1--1__value", $I->retrieveEntityField('createCategoryOne', 'id', 'test')); // stepKey: fillCategory
		$I->click("#conditions__1__children li:nth-of-type(1) a.rule-param-apply"); // stepKey: clickApply
		$I->waitForPageLoad(30); // stepKey: clickApplyWaitForPageLoad
		$I->click("[data-index='actions']"); // stepKey: openActionDropdown
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: discountType
		$I->fillField("[name='discount_amount']", "50"); // stepKey: fillDiscountValue
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: discardSubsequentRules
		$I->scrollToTopOfPage(); // stepKey: scrollToTop
		$I->waitForPageLoad(30); // stepKey: waitForApplied
		$I->comment("Entering Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectNotLoggedInCustomerGroup
		$I->comment("Exiting Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("3. Save and apply the new catalog price rule");
		$I->click("#save_and_apply"); // stepKey: saveAndApply
		$I->waitForPageLoad(30); // stepKey: saveAndApplyWaitForPageLoad
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("4. Verify the storefront");
		$I->amOnPage($I->retrieveEntityField('createCategoryOne', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryOne
		$I->see($I->retrieveEntityField('createSimpleProductOne', 'name', 'test'), "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductOne
		$I->see("$61.50", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductOnePrice
		$I->see("Regular Price $123.00", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductOneRegularPrice
		$I->amOnPage($I->retrieveEntityField('createCategoryTwo', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryTwo
		$I->see($I->retrieveEntityField('createSimpleProductTwo', 'name', 'test'), "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductTwo
		$I->see("$123.00", "//main//li[1]//div[@class='product-item-info']"); // stepKey: seeProductTwoPrice
		$I->dontSee("$61.50", "//main//li[1]//div[@class='product-item-info']"); // stepKey: dontSeeDiscount
	}
}
