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
 * @Title("MC-13654: Enable 'is undefined' condition to Scope Catalog Price rules by custom product attribute")
 * @Description("Enable 'is undefined' condition to Scope Catalog Price rules by custom product attribute<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminEnableAttributeIsUndefinedCatalogPriceRuleTest.xml<br>")
 * @TestCaseId("MC-13654")
 * @group CatalogRule
 */
class AdminEnableAttributeIsUndefinedCatalogPriceRuleTestCest
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
		$I->comment("Entering Action Group [login] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLogin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLogin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLogin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLogin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLogin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLogin
		$I->comment("Exiting Action Group [login] AdminLoginActionGroup");
		$I->createEntity("createFirstCategory", "hook", "ApiCategory", [], []); // stepKey: createFirstCategory
		$I->createEntity("createFirstProduct", "hook", "ApiSimpleProduct", ["createFirstCategory"], []); // stepKey: createFirstProduct
		$I->createEntity("createSecondProduct", "hook", "SimpleProduct", ["createFirstCategory"], []); // stepKey: createSecondProduct
		$I->createEntity("createProductAttribute", "hook", "productYesNoAttribute", [], []); // stepKey: createProductAttribute
		$I->createEntity("addToAttributeSetHandle", "hook", "AddToDefaultSet", ["createProductAttribute"], []); // stepKey: addToAttributeSetHandle
		$I->createEntity("createSecondCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createSecondCategory
		$I->createEntity("createThirdProduct", "hook", "SimpleProduct3", ["createSecondCategory"], []); // stepKey: createThirdProduct
		$I->createEntity("createForthProduct", "hook", "SimpleProduct4", ["createSecondCategory"], []); // stepKey: createForthProduct
		$createSecondProductAttributeFields['scope'] = "website";
		$I->createEntity("createSecondProductAttribute", "hook", "productDropDownAttribute", [], $createSecondProductAttributeFields); // stepKey: createSecondProductAttribute
		$runCron = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron
		$I->comment($runCron);
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete created data");
		$I->comment("Entering Action Group [goToCatalogPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToCatalogPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCatalogPriceRulePage
		$I->comment("Exiting Action Group [goToCatalogPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule
		$I->fillField(".col-name .admin__control-text", "CatalogPriceRule" . msq("CatalogRuleWithAllCustomerGroups")); // stepKey: fillIdentifierDeletePriceRule
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
		$I->click("[title='Reset Filter']"); // stepKey: resetFilters
		$I->deleteEntity("createFirstProduct", "hook"); // stepKey: deleteFirstProduct
		$I->deleteEntity("createSecondProduct", "hook"); // stepKey: deleteSecondProduct
		$I->deleteEntity("createFirstCategory", "hook"); // stepKey: deleteFirstCategory
		$I->deleteEntity("createThirdProduct", "hook"); // stepKey: deleteThirdProduct
		$I->deleteEntity("createForthProduct", "hook"); // stepKey: deleteForthProduct
		$I->deleteEntity("createSecondCategory", "hook"); // stepKey: deleteSecondCategory
		$I->deleteEntity("createSecondProductAttribute", "hook"); // stepKey: deleteSecondProductAttribute
		$I->comment("Entering Action Group [logout] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogout
		$I->comment("Exiting Action Group [logout] AdminLogoutActionGroup");
		$runCron = $I->magentoCLI("cron:run --group=index", 60); // stepKey: runCron
		$I->comment($runCron);
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
	 * @Stories({"Catalog price rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminEnableAttributeIsUndefinedCatalogPriceRuleTest(AcceptanceTester $I)
	{
		$I->comment("Create catalog price rule");
		$I->comment("Entering Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToPriceRulePage
		$I->comment("Exiting Action Group [goToPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [createCatalogPriceRule] CreateCatalogPriceRuleActionGroup");
		$I->click("#add"); // stepKey: addNewRuleCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewRuleCreateCatalogPriceRuleWaitForPageLoad
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("CatalogRuleWithAllCustomerGroups")); // stepKey: fillNameCreateCatalogPriceRule
		$I->click("input[name='is_active']+label"); // stepKey: selectActiveCreateCatalogPriceRule
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionCreateCatalogPriceRule
		$I->selectOption("[name='website_ids']", ["1"]); // stepKey: selectSiteCreateCatalogPriceRule
		$I->click("[data-index='actions']"); // stepKey: openActionDropdownCreateCatalogPriceRule
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountValueCreateCatalogPriceRule
		$I->scrollToTopOfPage(); // stepKey: scrollToTopCreateCatalogPriceRule
		$I->click("#save"); // stepKey: clickSaveCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: clickSaveCreateCatalogPriceRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAppliedCreateCatalogPriceRule
		$I->comment("Exiting Action Group [createCatalogPriceRule] CreateCatalogPriceRuleActionGroup");
		$I->comment("Entering Action Group [selectCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectCustomerGroup
		$I->comment("Exiting Action Group [selectCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("Entering Action Group [createCatalogPriceRuleCondition] CreateCatalogPriceRuleConditionWithAttributeActionGroup");
		$I->click("[data-index='block_promo_catalog_edit_tab_conditions']"); // stepKey: openConditionsTabCreateCatalogPriceRuleCondition
		$I->waitForPageLoad(30); // stepKey: waitForConditionTabOpenedCreateCatalogPriceRuleCondition
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionCreateCatalogPriceRuleCondition
		$I->waitForPageLoad(30); // stepKey: addNewConditionCreateCatalogPriceRuleConditionWaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", $I->retrieveEntityField('createProductAttribute', 'attribute[frontend_labels][0][label]', 'test')); // stepKey: selectTypeConditionCreateCatalogPriceRuleCondition
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionCreateCatalogPriceRuleConditionWaitForPageLoad
		$I->waitForElement("//ul[@id='conditions__1__children']//a[contains(text(), 'is')]", 30); // stepKey: waitForIsTargetCreateCatalogPriceRuleCondition
		$I->waitForPageLoad(30); // stepKey: waitForIsTargetCreateCatalogPriceRuleConditionWaitForPageLoad
		$I->click("//ul[@id='conditions__1__children']//a[contains(text(), 'is')]"); // stepKey: clickOnIsCreateCatalogPriceRuleCondition
		$I->waitForPageLoad(30); // stepKey: clickOnIsCreateCatalogPriceRuleConditionWaitForPageLoad
		$I->selectOption("//ul[@id='conditions__1__children']//select", "is undefined"); // stepKey: selectTargetConditionCreateCatalogPriceRuleCondition
		$I->waitForPageLoad(30); // stepKey: selectTargetConditionCreateCatalogPriceRuleConditionWaitForPageLoad
		$I->click("[name='from_date'] + button"); // stepKey: clickFromCalenderCreateCatalogPriceRuleCondition
		$I->waitForPageLoad(15); // stepKey: clickFromCalenderCreateCatalogPriceRuleConditionWaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickFromTodayCreateCatalogPriceRuleCondition
		$I->comment("Exiting Action Group [createCatalogPriceRuleCondition] CreateCatalogPriceRuleConditionWithAttributeActionGroup");
		$I->click("#save_and_apply"); // stepKey: clickSaveAndApplyRules
		$I->waitForPageLoad(30); // stepKey: clickSaveAndApplyRulesWaitForPageLoad
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Check Catalog Price Rule for first product");
		$I->amOnPage("/" . $I->retrieveEntityField('createFirstProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToFirstProductPage
		$I->waitForPageLoad(30); // stepKey: waitForFirstProductPageLoad
		$grabFirstProductUpdatedPrice = $I->grabTextFrom("div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: grabFirstProductUpdatedPrice
		$I->assertEquals("$110.70", ($grabFirstProductUpdatedPrice)); // stepKey: assertFirstProductUpdatedPrice
		$I->comment("Check Catalog Price Rule for second product");
		$I->amOnPage("/" . $I->retrieveEntityField('createSecondProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToSecondProductPage
		$I->waitForPageLoad(30); // stepKey: waitForSecondProductPageLoad
		$grabSecondProductUpdatedPrice = $I->grabTextFrom("div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: grabSecondProductUpdatedPrice
		$I->assertEquals("$110.70", ($grabFirstProductUpdatedPrice)); // stepKey: assertSecondProductUpdatedPrice
		$I->comment("Delete previous attribute and Catalog Price Rule");
		$I->deleteEntity("createProductAttribute", "test"); // stepKey: deleteProductAttribute
		$I->comment("Entering Action Group [goToCatalogPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToCatalogPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToCatalogPriceRulePage
		$I->comment("Exiting Action Group [goToCatalogPriceRulePage] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule
		$I->fillField(".col-name .admin__control-text", "CatalogPriceRule" . msq("CatalogRuleWithAllCustomerGroups")); // stepKey: fillIdentifierDeletePriceRule
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
		$I->comment("Add new attribute to Default set");
		$I->createEntity("addToAttributeSetHandle1", "test", "AddToDefaultSet", ["createSecondProductAttribute"], []); // stepKey: addToAttributeSetHandle1
		$I->comment("Create new Catalog Price Rule");
		$I->comment("Entering Action Group [goToPriceRulePage1] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToPriceRulePage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToPriceRulePage1
		$I->comment("Exiting Action Group [goToPriceRulePage1] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [createCatalogPriceRule1] CreateCatalogPriceRuleActionGroup");
		$I->click("#add"); // stepKey: addNewRuleCreateCatalogPriceRule1
		$I->waitForPageLoad(30); // stepKey: addNewRuleCreateCatalogPriceRule1WaitForPageLoad
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("CatalogRuleWithAllCustomerGroups")); // stepKey: fillNameCreateCatalogPriceRule1
		$I->click("input[name='is_active']+label"); // stepKey: selectActiveCreateCatalogPriceRule1
		$I->fillField("[name='description']", "Catalog Price Rule Description"); // stepKey: fillDescriptionCreateCatalogPriceRule1
		$I->selectOption("[name='website_ids']", ["1"]); // stepKey: selectSiteCreateCatalogPriceRule1
		$I->click("[data-index='actions']"); // stepKey: openActionDropdownCreateCatalogPriceRule1
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountValueCreateCatalogPriceRule1
		$I->scrollToTopOfPage(); // stepKey: scrollToTopCreateCatalogPriceRule1
		$I->click("#save"); // stepKey: clickSaveCreateCatalogPriceRule1
		$I->waitForPageLoad(30); // stepKey: clickSaveCreateCatalogPriceRule1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAppliedCreateCatalogPriceRule1
		$I->comment("Exiting Action Group [createCatalogPriceRule1] CreateCatalogPriceRuleActionGroup");
		$I->comment("Entering Action Group [selectCustomerGroup1] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectCustomerGroup1
		$I->comment("Exiting Action Group [selectCustomerGroup1] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("Entering Action Group [createCatalogPriceRuleCondition1] CreateCatalogPriceRuleConditionWithAttributeActionGroup");
		$I->click("[data-index='block_promo_catalog_edit_tab_conditions']"); // stepKey: openConditionsTabCreateCatalogPriceRuleCondition1
		$I->waitForPageLoad(30); // stepKey: waitForConditionTabOpenedCreateCatalogPriceRuleCondition1
		$I->click(".rule-param.rule-param-new-child"); // stepKey: addNewConditionCreateCatalogPriceRuleCondition1
		$I->waitForPageLoad(30); // stepKey: addNewConditionCreateCatalogPriceRuleCondition1WaitForPageLoad
		$I->selectOption("select#conditions__1__new_child", $I->retrieveEntityField('createSecondProductAttribute', 'attribute[frontend_labels][0][label]', 'test')); // stepKey: selectTypeConditionCreateCatalogPriceRuleCondition1
		$I->waitForPageLoad(30); // stepKey: selectTypeConditionCreateCatalogPriceRuleCondition1WaitForPageLoad
		$I->waitForElement("//ul[@id='conditions__1__children']//a[contains(text(), 'is')]", 30); // stepKey: waitForIsTargetCreateCatalogPriceRuleCondition1
		$I->waitForPageLoad(30); // stepKey: waitForIsTargetCreateCatalogPriceRuleCondition1WaitForPageLoad
		$I->click("//ul[@id='conditions__1__children']//a[contains(text(), 'is')]"); // stepKey: clickOnIsCreateCatalogPriceRuleCondition1
		$I->waitForPageLoad(30); // stepKey: clickOnIsCreateCatalogPriceRuleCondition1WaitForPageLoad
		$I->selectOption("//ul[@id='conditions__1__children']//select", "is undefined"); // stepKey: selectTargetConditionCreateCatalogPriceRuleCondition1
		$I->waitForPageLoad(30); // stepKey: selectTargetConditionCreateCatalogPriceRuleCondition1WaitForPageLoad
		$I->click("[name='from_date'] + button"); // stepKey: clickFromCalenderCreateCatalogPriceRuleCondition1
		$I->waitForPageLoad(15); // stepKey: clickFromCalenderCreateCatalogPriceRuleCondition1WaitForPageLoad
		$I->click("#ui-datepicker-div [data-handler='today']"); // stepKey: clickFromTodayCreateCatalogPriceRuleCondition1
		$I->comment("Exiting Action Group [createCatalogPriceRuleCondition1] CreateCatalogPriceRuleConditionWithAttributeActionGroup");
		$I->click("#save_and_apply"); // stepKey: clickSaveAndApplyRules1
		$I->waitForPageLoad(30); // stepKey: clickSaveAndApplyRules1WaitForPageLoad
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Check Catalog Price Rule for third product");
		$I->amOnPage("/" . $I->retrieveEntityField('createThirdProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToThirdProductPage
		$I->waitForPageLoad(30); // stepKey: waitForThirdProductPageLoad
		$grabThirdProductUpdatedPrice = $I->grabTextFrom("div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: grabThirdProductUpdatedPrice
		$I->assertEquals("$110.70", ($grabThirdProductUpdatedPrice)); // stepKey: assertThirdProductUpdatedPrice
		$I->comment("Check Catalog Price Rule for forth product");
		$I->amOnPage("/" . $I->retrieveEntityField('createForthProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToForthProductPage
		$I->waitForPageLoad(30); // stepKey: waitForForthProductPageLoad
		$grabForthProductUpdatedPrice = $I->grabTextFrom("div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: grabForthProductUpdatedPrice
		$I->assertEquals("$110.70", ($grabForthProductUpdatedPrice)); // stepKey: assertForthProductUpdatedPrice
	}
}
