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
 * @Title("MC-13977: Create Inactive Catalog Price Rule")
 * @Description("Login as admin and create inactive catalog price Rule<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminCreateInactiveCatalogPriceRuleTest.xml<br>")
 * @TestCaseId("MC-13977")
 * @group mtf_migrated
 */
class AdminCreateInactiveCatalogPriceRuleTestCest
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
		$I->comment("Entering Action Group [loginToAdminPanel] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginToAdminPanel
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginToAdminPanel
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginToAdminPanel
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginToAdminPanel
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginToAdminPanelWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginToAdminPanel
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginToAdminPanel
		$I->comment("Exiting Action Group [loginToAdminPanel] AdminLoginActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [searchCreatedCatalogRule] AdminSearchCatalogRuleInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageSearchCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageSearchCreatedCatalogRule
		$I->click("//button[@title='Reset Filter']"); // stepKey: clickOnResetFilterSearchCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterSearchCreatedCatalogRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheGridPageToLoadSearchCreatedCatalogRule
		$I->fillField("//td[@data-column='name']/input[@name='name']", "InactiveCatalogRule" . msq("InactiveCatalogRule")); // stepKey: fillTheRuleFilterSearchCreatedCatalogRule
		$I->click("//div[@id='promo_catalog_grid']//button[@title='Search']"); // stepKey: clickOnSearchButtonSearchCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButtonSearchCreatedCatalogRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheSearchResultSearchCreatedCatalogRule
		$I->comment("Exiting Action Group [searchCreatedCatalogRule] AdminSearchCatalogRuleInGridActionGroup");
		$I->comment("Entering Action Group [selectCreatedCatalogRule] AdminSelectCatalogRuleFromGridActionGroup");
		$I->click("//tr[@data-role='row']//td[contains(.,'InactiveCatalogRule" . msq("InactiveCatalogRule") . "')]"); // stepKey: selectRowSelectCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectCreatedCatalogRule
		$I->comment("Exiting Action Group [selectCreatedCatalogRule] AdminSelectCatalogRuleFromGridActionGroup");
		$I->comment("Entering Action Group [deleteTheCatalogRule] AdminDeleteCatalogRuleActionGroup");
		$I->click("#delete"); // stepKey: clickOnDeleteButtonDeleteTheCatalogRule
		$I->waitForPageLoad(30); // stepKey: clickOnDeleteButtonDeleteTheCatalogRuleWaitForPageLoad
		$I->waitForElementVisible("//button[@class='action-primary action-accept']", 30); // stepKey: waitForOkButtonToBeVisibleDeleteTheCatalogRule
		$I->click("//button[@class='action-primary action-accept']"); // stepKey: clickOnOkButtonDeleteTheCatalogRule
		$I->waitForPageLoad(30); // stepKey: waitForPagetoLoadDeleteTheCatalogRule
		$I->see("You deleted the rule.", "#messages"); // stepKey: seeSuccessDeleteMessageDeleteTheCatalogRule
		$I->comment("Exiting Action Group [deleteTheCatalogRule] AdminDeleteCatalogRuleActionGroup");
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
	 * @Stories({"Create Catalog Price Rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogRule"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateInactiveCatalogPriceRuleTest(AcceptanceTester $I)
	{
		$I->comment("Create Inactive Catalog Price Rule");
		$I->comment("Entering Action Group [createCatalogPriceRule] AdminCreateNewCatalogPriceRuleActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePageCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadCreateCatalogPriceRule
		$I->fillField("[name='name']", "InactiveCatalogRule" . msq("InactiveCatalogRule")); // stepKey: fillNameCreateCatalogPriceRule
		$I->fillField("[name='description']", "Inactive Catalog Price Rule Description"); // stepKey: fillDescriptionCreateCatalogPriceRule
		$I->selectOption("[name='website_ids']", "1"); // stepKey: selectWebSiteCreateCatalogPriceRule
		$I->selectOption("[name='customer_group_ids']", "General"); // stepKey: selectCustomerGroupCreateCatalogPriceRule
		$I->scrollTo("[data-index='actions']"); // stepKey: scrollToActionTabCreateCatalogPriceRule
		$I->click("[data-index='actions']"); // stepKey: openActionDropdownCreateCatalogPriceRule
		$I->selectOption("[name='simple_action']", "by_fixed"); // stepKey: discountTypeCreateCatalogPriceRule
		$I->fillField("[name='discount_amount']", "10.000000"); // stepKey: fillDiscountValueCreateCatalogPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: discardSubsequentRulesCreateCatalogPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAppliedCreateCatalogPriceRule
		$I->comment("Exiting Action Group [createCatalogPriceRule] AdminCreateNewCatalogPriceRuleActionGroup");
		$I->comment("Save and Apply Rules");
		$I->comment("Entering Action Group [saveAndApplyRules] AdminSaveAndApplyRulesActionGroup");
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSaveAndApplyRules
		$I->scrollToTopOfPage(); // stepKey: scrollToTopSaveAndApplyRules
		$I->click("#save"); // stepKey: saveTheCatalogRuleSaveAndApplyRules
		$I->waitForPageLoad(30); // stepKey: saveTheCatalogRuleSaveAndApplyRulesWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1SaveAndApplyRules
		$I->seeElement("//div[@class='message message-notice notice']//div[contains(.,'We found updated rules that are not applied. Please click')]"); // stepKey: seeMessageToUpdateTheCatalogRulesSaveAndApplyRules
		$I->see("You saved the rule.", "#messages"); // stepKey: seeSuccessMessageSaveAndApplyRules
		$I->click("#apply_rules"); // stepKey: applyRulesSaveAndApplyRules
		$I->waitForPageLoad(30); // stepKey: applyRulesSaveAndApplyRulesWaitForPageLoad
		$I->see("Updated rules applied.", ".message-success"); // stepKey: assertSuccessSaveAndApplyRules
		$I->comment("Exiting Action Group [saveAndApplyRules] AdminSaveAndApplyRulesActionGroup");
		$I->comment("Search Catalog Rule in Grid");
		$I->comment("Entering Action Group [searchAndSelectCreatedCatalogRule] AdminSearchCatalogRuleInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageSearchAndSelectCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageSearchAndSelectCreatedCatalogRule
		$I->click("//button[@title='Reset Filter']"); // stepKey: clickOnResetFilterSearchAndSelectCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterSearchAndSelectCreatedCatalogRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheGridPageToLoadSearchAndSelectCreatedCatalogRule
		$I->fillField("//td[@data-column='name']/input[@name='name']", "InactiveCatalogRule" . msq("InactiveCatalogRule")); // stepKey: fillTheRuleFilterSearchAndSelectCreatedCatalogRule
		$I->click("//div[@id='promo_catalog_grid']//button[@title='Search']"); // stepKey: clickOnSearchButtonSearchAndSelectCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButtonSearchAndSelectCreatedCatalogRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheSearchResultSearchAndSelectCreatedCatalogRule
		$I->comment("Exiting Action Group [searchAndSelectCreatedCatalogRule] AdminSearchCatalogRuleInGridActionGroup");
		$I->comment("Select Catalog Rule in Grid");
		$I->comment("Entering Action Group [selectCreatedCatalogRule] AdminSelectCatalogRuleFromGridActionGroup");
		$I->click("//tr[@data-role='row']//td[contains(.,'InactiveCatalogRule" . msq("InactiveCatalogRule") . "')]"); // stepKey: selectRowSelectCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadSelectCreatedCatalogRule
		$I->comment("Exiting Action Group [selectCreatedCatalogRule] AdminSelectCatalogRuleFromGridActionGroup");
		$catalogRuleId = $I->grabFromCurrentUrl("#\/([0-9]*)?\/$#"); // stepKey: catalogRuleId
		$I->comment("Assert catalog Price Rule Form");
		$I->comment("Entering Action Group [assertCatalogRuleForm] AssertCatalogPriceRuleFormActionGroup");
		$I->seeInField("[name='name']", "InactiveCatalogRule" . msq("InactiveCatalogRule")); // stepKey: fillNameAssertCatalogRuleForm
		$I->seeInField("[name='description']", "Inactive Catalog Price Rule Description"); // stepKey: fillDescriptionAssertCatalogRuleForm
		$I->see("Main Website", "[name='website_ids']"); // stepKey: seeWebSiteAssertCatalogRuleForm
		$I->seeOptionIsSelected("[name='customer_group_ids']", "General"); // stepKey: selectCustomerGroupAssertCatalogRuleForm
		$I->scrollTo("[data-index='actions']"); // stepKey: scrollToActionTabAssertCatalogRuleForm
		$I->click("[data-index='actions']"); // stepKey: openActionDropdownAssertCatalogRuleForm
		$I->seeInField("[name='simple_action']", "by_fixed"); // stepKey: discountTypeAssertCatalogRuleForm
		$I->seeInField("[name='discount_amount']", "10.000000"); // stepKey: fillDiscountValueAssertCatalogRuleForm
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadAssertCatalogRuleForm
		$I->comment("Exiting Action Group [assertCatalogRuleForm] AssertCatalogPriceRuleFormActionGroup");
		$I->dontSeeCheckboxIsChecked("input[name='is_active']+label"); // stepKey: verifyInactiveRule
		$I->comment("Search Catalog Rule in Grid");
		$I->comment("Entering Action Group [searchCreatedCatalogRule] AdminSearchCatalogRuleInGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageSearchCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageSearchCreatedCatalogRule
		$I->click("//button[@title='Reset Filter']"); // stepKey: clickOnResetFilterSearchCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: clickOnResetFilterSearchCreatedCatalogRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheGridPageToLoadSearchCreatedCatalogRule
		$I->fillField("//td[@data-column='name']/input[@name='name']", "InactiveCatalogRule" . msq("InactiveCatalogRule")); // stepKey: fillTheRuleFilterSearchCreatedCatalogRule
		$I->click("//div[@id='promo_catalog_grid']//button[@title='Search']"); // stepKey: clickOnSearchButtonSearchCreatedCatalogRule
		$I->waitForPageLoad(30); // stepKey: clickOnSearchButtonSearchCreatedCatalogRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForTheSearchResultSearchCreatedCatalogRule
		$I->comment("Exiting Action Group [searchCreatedCatalogRule] AdminSearchCatalogRuleInGridActionGroup");
		$I->comment("Assert Catalog Rule In Grid");
		$I->comment("Entering Action Group [assertCatalogRuleInGrid] AssertCatalogRuleInGridActionGroup");
		$I->see("$catalogRuleId", "//tr[@data-role='row']"); // stepKey: seeCatalogRuleIdAssertCatalogRuleInGrid
		$I->see("InactiveCatalogRule" . msq("InactiveCatalogRule"), "//tr[@data-role='row']"); // stepKey: seeCatalogRuleNameAssertCatalogRuleInGrid
		$I->see("Inactive", "//tr[@data-role='row']"); // stepKey: seeCatalogRuleStatusAssertCatalogRuleInGrid
		$I->see("Main Website", "//tr[@data-role='row']"); // stepKey: seeCatalogRuleWebsiteAssertCatalogRuleInGrid
		$I->comment("Exiting Action Group [assertCatalogRuleInGrid] AssertCatalogRuleInGridActionGroup");
	}
}
