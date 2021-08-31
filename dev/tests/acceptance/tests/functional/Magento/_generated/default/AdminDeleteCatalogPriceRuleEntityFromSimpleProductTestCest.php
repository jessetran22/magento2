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
 * @Title("MC-14073: Delete Catalog Price Rule for Simple Product")
 * @Description("Assert that Catalog Price Rule is not applied for simple product.<h3>Test files</h3>app/code/Magento/CatalogRule/Test/Mftf/Test/AdminDeleteCatalogPriceRuleEntityTest/AdminDeleteCatalogPriceRuleEntityFromSimpleProductTest.xml<br>")
 * @TestCaseId("MC-14073")
 * @group CatalogRule
 * @group mtf_migrated
 */
class AdminDeleteCatalogPriceRuleEntityFromSimpleProductTestCest
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
		$I->createEntity("createCustomer1", "hook", "Simple_US_Customer", [], []); // stepKey: createCustomer1
		$I->createEntity("createCategory1", "hook", "_defaultCategory", [], []); // stepKey: createCategory1
		$I->createEntity("createProduct1", "hook", "SimpleProduct", ["createCategory1"], []); // stepKey: createProduct1
		$I->comment("Entering Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin1
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin1
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin1
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin1
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdmin1WaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin1
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin1
		$I->comment("Exiting Action Group [loginAsAdmin1] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/new/"); // stepKey: openNewCatalogPriceRulePage
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1
		$I->comment("Entering Action Group [createCatalogPriceRuleViaTheUi1] CreateCatalogPriceRuleViaTheUiActionGroup");
		$I->fillField("[name='name']", "Delete Active Catalog Rule with conditions " . msq("DeleteActiveCatalogPriceRuleWithConditions")); // stepKey: fillName1CreateCatalogPriceRuleViaTheUi1
		$I->fillField("[name='description']", "Rule Description"); // stepKey: fillDescription1CreateCatalogPriceRuleViaTheUi1
		$I->selectOption("[name='website_ids']", "1"); // stepKey: selectWebSite1CreateCatalogPriceRuleViaTheUi1
		$I->selectOption("[name='customer_group_ids']", "General"); // stepKey: selectCustomerGroup1CreateCatalogPriceRuleViaTheUi1
		$I->scrollTo("[data-index='actions']"); // stepKey: scrollToActionTab1CreateCatalogPriceRuleViaTheUi1
		$I->click("[data-index='actions']"); // stepKey: openActionDropdown1CreateCatalogPriceRuleViaTheUi1
		$I->selectOption("[name='simple_action']", "by_percent"); // stepKey: discountType1CreateCatalogPriceRuleViaTheUi1
		$I->fillField("[name='discount_amount']", "10"); // stepKey: fillDiscountValue1CreateCatalogPriceRuleViaTheUi1
		$I->selectOption("[name='stop_rules_processing']", "Yes"); // stepKey: discardSubsequentRules1CreateCatalogPriceRuleViaTheUi1
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad1CreateCatalogPriceRuleViaTheUi1
		$I->scrollToTopOfPage(); // stepKey: scrollToTop1CreateCatalogPriceRuleViaTheUi1
		$I->comment("Exiting Action Group [createCatalogPriceRuleViaTheUi1] CreateCatalogPriceRuleViaTheUiActionGroup");
		$I->click("#save"); // stepKey: saveTheCatalogRule
		$I->waitForPageLoad(30); // stepKey: saveTheCatalogRuleWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoad3
		$I->see("You saved the rule.", "#messages"); // stepKey: seeSuccessMessage
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [logoutOfAdmin1] AdminLogoutActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin/auth/logout/"); // stepKey: amOnLogoutPageLogoutOfAdmin1
		$I->comment("Exiting Action Group [logoutOfAdmin1] AdminLogoutActionGroup");
		$I->deleteEntity("createCustomer1", "hook"); // stepKey: deleteCustomer1
		$I->deleteEntity("createProduct1", "hook"); // stepKey: deleteSimpleProduct1
		$I->deleteEntity("createCategory1", "hook"); // stepKey: deleteCategoryFirst1
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
	 * @Stories({"Delete Catalog Price Rule"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Features({"CatalogRule"})
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function AdminDeleteCatalogPriceRuleEntityFromSimpleProductTest(AcceptanceTester $I)
	{
		$I->comment("Delete the simple product and catalog price rule");
		$I->comment("Entering Action Group [goToPriceRulePage1] AdminOpenCatalogPriceRulePageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog_rule/promo_catalog/"); // stepKey: openCatalogRulePageGoToPriceRulePage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadGoToPriceRulePage1
		$I->comment("Exiting Action Group [goToPriceRulePage1] AdminOpenCatalogPriceRulePageActionGroup");
		$I->comment("Entering Action Group [deletePriceRule1] deleteEntitySecondaryGrid");
		$I->comment("search for the name");
		$I->click("[title='Reset Filter']"); // stepKey: resetFiltersDeletePriceRule1
		$I->fillField(".col-name .admin__control-text", "Delete Active Catalog Rule with conditions " . msq("DeleteActiveCatalogPriceRuleWithConditions")); // stepKey: fillIdentifierDeletePriceRule1
		$I->click(".admin__filter-actions [title='Search']"); // stepKey: searchForNameDeletePriceRule1
		$I->click("tr[data-role='row']"); // stepKey: clickResultDeletePriceRule1
		$I->waitForPageLoad(30); // stepKey: waitForTaxRateLoadDeletePriceRule1
		$I->comment("delete the rule");
		$I->click("#delete"); // stepKey: clickDeleteDeletePriceRule1
		$I->waitForPageLoad(30); // stepKey: clickDeleteDeletePriceRule1WaitForPageLoad
		$I->click("aside.confirm .modal-footer button.action-accept"); // stepKey: clickOkDeletePriceRule1
		$I->waitForPageLoad(60); // stepKey: clickOkDeletePriceRule1WaitForPageLoad
		$I->see("deleted", ".message-success"); // stepKey: seeSuccessDeletePriceRule1
		$I->comment("Exiting Action Group [deletePriceRule1] deleteEntitySecondaryGrid");
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad1
		$I->comment("Assert that the Success message is present after the delete");
		$I->see("You deleted the rule.", "#messages div.message-success"); // stepKey: seeDeletedRuleMessage1
		$I->comment("Adding the comment to replace CliIndexerReindexActionGroup action group ('indexer:reindex' commands) for preserving Backward Compatibility");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
		$I->comment("Assert that the rule isn't present on the Category page");
		$I->amOnPage($I->retrieveEntityField('createCategory1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCategoryPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad3
		$I->dontSee("Regular Price", "//div[descendant::*[contains(text(), '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]]//*[contains(@class, 'price-label')]"); // stepKey: dontSeeRegularPriceText1
		$I->dontSeeElement("//div[contains(@class, 'product-item-info')][.//a[contains(text(), '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]]//span[@class='special-price']/span"); // stepKey: dontSeeSpecialPrice1
		$I->comment("Assert that the rule isn't present on the Product page");
		$I->amOnPage($I->retrieveEntityField('createProduct1', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontProductPage1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad4
		$I->dontSee("Regular Price", ".old-price .price-label"); // stepKey: dontSeeRegularPRiceText2
		$I->see($I->retrieveEntityField('createProduct1', 'price', 'test'), "div.price-box.price-final_price"); // stepKey: seeTrueProductPrice1
		$I->comment("Assert that the rule isn't present in the Shopping Cart");
		$I->comment("Entering Action Group [addProductToShoppingCart1] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToShoppingCart1
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToShoppingCart1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToShoppingCart1
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToShoppingCart1
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToShoppingCart1
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToShoppingCart1
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToShoppingCart1
		$I->see("You added " . $I->retrieveEntityField('createProduct1', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToShoppingCart1
		$I->comment("Exiting Action Group [addProductToShoppingCart1] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Entering Action Group [openMiniShoppingCart1] StorefrontClickOnMiniCartActionGroup");
		$I->scrollToTopOfPage(); // stepKey: scrollToTheTopOfThePageOpenMiniShoppingCart1
		$I->waitForElementVisible("a.showcart", 30); // stepKey: waitForElementToBeVisibleOpenMiniShoppingCart1
		$I->waitForPageLoad(60); // stepKey: waitForElementToBeVisibleOpenMiniShoppingCart1WaitForPageLoad
		$I->click("a.showcart"); // stepKey: clickOnMiniCartOpenMiniShoppingCart1
		$I->waitForPageLoad(60); // stepKey: clickOnMiniCartOpenMiniShoppingCart1WaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageToLoadOpenMiniShoppingCart1
		$I->comment("Exiting Action Group [openMiniShoppingCart1] StorefrontClickOnMiniCartActionGroup");
		$I->see($I->retrieveEntityField('createProduct1', 'price', 'test'), "//header//ol[@id='mini-cart']//div[@class='product-item-details'][.//a[contains(text(), '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]]//span[@class='price']"); // stepKey: seeCorrectProductPrice1
		$I->comment("Assert that the rule isn't present on the Checkout page");
		$I->click("#top-cart-btn-checkout"); // stepKey: goToCheckout1
		$I->waitForPageLoad(30); // stepKey: goToCheckout1WaitForPageLoad
		$I->conditionalClick("//*[contains(@class, 'items-in-cart')][not(contains(@class, 'active'))]", "//*[contains(@class, 'items-in-cart')][not(contains(@class, 'active'))]", true); // stepKey: expandShoppingCartSummary1
		$I->see($I->retrieveEntityField('createProduct1', 'price', 'test'), "//div[descendant::*[contains(text(), '" . $I->retrieveEntityField('createProduct1', 'name', 'test') . "')]]//*[contains(@class, 'subtotal')]"); // stepKey: seeCorrectProductPriceOnCheckout1
	}
}
