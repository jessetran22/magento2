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
 * @Title("MC-93: Admin should be able to create a catalog price rule applied as a fixed amount (for simple product)")
 * @Description("Admin should be able to create a catalog price rule applied as a fixed amount (for simple product)<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminCreateCatalogPriceRuleTest/AdminCreateCatalogPriceRuleByFixedTest.xml<br>")
 * @TestCaseId("MC-93")
 * @group CatalogRule
 */
class AdminCreateCatalogPriceRuleByFixedTestCest
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
		$I->comment("Create the simple product and category that it will be in");
		$I->createEntity("createCategory", "hook", "ApiCategory", [], []); // stepKey: createCategory
		$I->createEntity("createProduct", "hook", "ApiSimpleProduct", ["createCategory"], []); // stepKey: createProduct
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("log in and create the price rule");
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Entering Action Group [createNewPriceRule] NewCatalogPriceRuleByUIActionGroup");
		$I->comment("Go to the admin Catalog rule grid and add a new one");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePageCreateNewPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForPriceRulePageCreateNewPriceRule
		$I->click("#add"); // stepKey: addNewRuleCreateNewPriceRule
		$I->waitForPageLoad(30); // stepKey: addNewRuleCreateNewPriceRuleWaitForPageLoad
		$I->comment("Fill the form according the attributes of the entity");
		$I->fillField("[name='name']", "CatalogPriceRule" . msq("CatalogRuleByFixed")); // stepKey: fillNameCreateNewPriceRule
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
		$I->fillField("[name='discount_amount']", "12.3"); // stepKey: fillDiscountValueCreateNewPriceRule
		$I->selectOption("[name='simple_action']", "by_fixed"); // stepKey: discountTypeCreateNewPriceRule
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: discardSubsequentRulesCreateNewPriceRule
		$I->comment("Scroll to top and either save or save and apply after the action group");
		$I->scrollToTopOfPage(); // stepKey: scrollToTopCreateNewPriceRule
		$I->waitForPageLoad(30); // stepKey: waitForAppliedCreateNewPriceRule
		$I->comment("Exiting Action Group [createNewPriceRule] NewCatalogPriceRuleByUIActionGroup");
		$I->comment("Entering Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->comment("This actionGroup was created to be merged from B2B because B2B has a very different form control here");
		$I->selectOption("select[name='customer_group_ids']", "NOT LOGGED IN"); // stepKey: selectCustomerGroupSelectNotLoggedInCustomerGroup
		$I->comment("Exiting Action Group [selectNotLoggedInCustomerGroup] SelectNotLoggedInCustomerGroupActionGroup");
		$I->click("#save_and_apply"); // stepKey: saveAndApply
		$I->waitForPageLoad(30); // stepKey: saveAndApplyWaitForPageLoad
		$I->see("You saved the rule.", ".message-success"); // stepKey: assertSuccess
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("delete the simple product and catalog price rule and logout");
		$I->amOnPage("admin/catalog_rule/promo_catalog/"); // stepKey: goToPriceRulePage
		$I->comment("Entering Action Group [deletePriceRule] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule
		$I->fillField(".col-name .admin__control-text", "CatalogPriceRule" . msq("CatalogRuleByFixed")); // stepKey: fillIdentifierDeletePriceRule
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
		$I->deleteEntity("createProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Create catalog price rule"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminCreateCatalogPriceRuleByFixedTest(AcceptanceTester $I)
	{
		$I->comment("Go to category page and make sure that all of the prices are correct");
		$I->amOnPage($I->retrieveEntityField('createCategory', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToCategoryPage
		$I->waitForPageLoad(30); // stepKey: waitForCategory
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), "//main//li[1]//span[@class='old-price']//span[@class='price']"); // stepKey: seeOldPrice
		$I->see("$110.70", "//main//li[1]//span[@class='special-price']//span[@class='price']"); // stepKey: seeNewPrice
		$I->comment("Go to the simple product page and check that the prices are correct");
		$I->amOnPage($I->retrieveEntityField('createProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPage
		$I->see("Regular Price", ".old-price .price-label"); // stepKey: seeOldPriceTag
		$I->see($I->retrieveEntityField('createProduct', 'price', 'test'), ".old-price span.price"); // stepKey: seeOldPrice2
		$I->see("$110.70", "div.price-box.price-final_price [data-price-type='finalPrice'] .price"); // stepKey: seeNewPrice2
		$I->comment("Add the product to cart and check that the price is correct there");
		$I->comment("Entering Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddToCartFromStorefrontProductPage
		$I->waitForPageLoad(60); // stepKey: addToCartAddToCartFromStorefrontProductPageWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddToCartFromStorefrontProductPage
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddToCartFromStorefrontProductPage
		$I->comment("Exiting Action Group [addToCartFromStorefrontProductPage] StorefrontClickAddToCartOnProductPageActionGroup");
		$I->comment("Entering Action Group [goToCheckout] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCheckout
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCheckout
		$I->comment("Exiting Action Group [goToCheckout] StorefrontCartPageOpenActionGroup");
		$I->see("$110.70", "//*[@id='cart-totals']//tr[@class='totals sub']//td//span[@class='price']"); // stepKey: seeNewPriceInCart
	}
}
