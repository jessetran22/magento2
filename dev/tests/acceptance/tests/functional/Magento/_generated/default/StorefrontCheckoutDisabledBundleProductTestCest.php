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
 * @Title("MC-29105: Customer should be able to checkout if there is at least one available product in the cart")
 * @Description("Customer should be able to checkout if there is at least one available product in the cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontCheckoutDisabledBundleProductTest.xml<br>")
 * @TestCaseId("MC-29105")
 * @group checkout
 */
class StorefrontCheckoutDisabledBundleProductTestCest
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
		$I->comment("Create category and simple product");
		$I->createEntity("createCategory", "hook", "SimpleSubCategory", [], []); // stepKey: createCategory
		$I->createEntity("createSimpleProduct", "hook", "_defaultProduct", ["createCategory"], []); // stepKey: createSimpleProduct
		$I->comment("Create bundle product");
		$I->createEntity("createBundleDynamicProduct", "hook", "ApiBundleProductPriceViewRange", ["createCategory"], []); // stepKey: createBundleDynamicProduct
		$I->createEntity("bundleOption", "hook", "DropDownBundleOption", ["createBundleDynamicProduct"], []); // stepKey: bundleOption
		$I->createEntity("createNewBundleLink", "hook", "ApiBundleLink", ["createBundleDynamicProduct", "bundleOption", "createSimpleProduct"], []); // stepKey: createNewBundleLink
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, ""); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
		$I->comment("Adding the comment to replace CliCacheFlushActionGroup action group ('cache:flush' command) for preserving Backward Compatibility");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete category");
		$I->deleteEntity("createCategory", "hook"); // stepKey: deleteCategory
		$I->comment("Delete bundle product data");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createBundleDynamicProduct", "hook"); // stepKey: deleteBundleProduct
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
	 * @Features({"Checkout"})
	 * @Stories({"Disabled bundle product is preventing customer to checkout for the first attempt"})
	 * @Severity(level = SeverityLevel::TRIVIAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontCheckoutDisabledBundleProductTest(AcceptanceTester $I)
	{
		$I->comment("Add simple product to the cart");
		$I->comment("Entering Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('createSimpleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToProductPageCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForProductPageCartAddSimpleProductToCart
		$I->click("button.action.tocart.primary"); // stepKey: addToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: addToCartCartAddSimpleProductToCartWaitForPageLoad
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingCartAddSimpleProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedCartAddSimpleProductToCart
		$I->waitForElementVisible("//button/span[text()='Add to Cart']", 30); // stepKey: waitForElementVisibleAddToCartButtonTitleIsAddToCartCartAddSimpleProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadCartAddSimpleProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForProductAddedMessageCartAddSimpleProductToCart
		$I->see("You added " . $I->retrieveEntityField('createSimpleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageCartAddSimpleProductToCart
		$I->comment("Exiting Action Group [cartAddSimpleProductToCart] AddSimpleProductToCartActionGroup");
		$I->comment("Go to bundle product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createBundleDynamicProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Add bundle product to the cart");
		$I->comment("Entering Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->waitForElementVisible("#bundle-slide", 30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: waitForCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->click("#bundle-slide"); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCart
		$I->waitForPageLoad(30); // stepKey: clickOnCustomizeAndAddToCartButtonClickCustomizeAndAddToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadClickCustomizeAndAddToCart
		$I->comment("Exiting Action Group [clickCustomizeAndAddToCart] StorefrontSelectCustomizeAndAddToTheCartButtonActionGroup");
		$I->comment("Entering Action Group [addProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->click("#product-addtocart-button"); // stepKey: addToCartAddProductToCart
		$I->waitForPageLoad(60); // stepKey: addToCartAddProductToCartWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Adding...']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddingAddProductToCart
		$I->waitForElementNotVisible("//button/span[text()='Added']", 30); // stepKey: waitForElementNotVisibleAddToCartButtonTitleIsAddedAddProductToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadAddProductToCart
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('createBundleDynamicProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Login to admin panel");
		$I->openNewTab(); // stepKey: openNewTab
		$I->comment("Entering Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/admin"); // stepKey: navigateToAdminLoginAsAdmin
		$I->fillField("#username", getenv("MAGENTO_ADMIN_USERNAME")); // stepKey: fillUsernameLoginAsAdmin
		$I->fillField("#login", getenv("MAGENTO_ADMIN_PASSWORD")); // stepKey: fillPasswordLoginAsAdmin
		$I->click(".actions .action-primary"); // stepKey: clickLoginLoginAsAdmin
		$I->waitForPageLoad(30); // stepKey: clickLoginLoginAsAdminWaitForPageLoad
		$I->conditionalClick(".modal-popup .action-secondary", ".modal-popup .action-secondary", true); // stepKey: clickDontAllowButtonIfVisibleLoginAsAdmin
		$I->closeAdminNotification(); // stepKey: closeAdminNotificationLoginAsAdmin
		$I->comment("Exiting Action Group [loginAsAdmin] AdminLoginActionGroup");
		$I->comment("Find the first simple product that we just created using the product grid and go to its page");
		$I->comment("Entering Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: goToProductIndexPageVisitAdminProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductIndexPageLoadVisitAdminProductPage
		$I->comment("Exiting Action Group [visitAdminProductPage] AdminOpenProductIndexPageActionGroup");
		$I->comment("Disabled bundle product from grid");
		$I->comment("Entering Action Group [disabledProductFromGrid] ChangeStatusProductUsingProductGridActionGroup");
		$I->amOnPage((getenv("MAGENTO_BACKEND_BASE_URL") ? rtrim(getenv("MAGENTO_BACKEND_BASE_URL"), "/") : "") . "/" . getenv("MAGENTO_BACKEND_NAME") . "/catalog/product/index"); // stepKey: visitAdminProductPageDisabledProductFromGrid
		$I->waitForPageLoad(60); // stepKey: waitForPageLoadInitialDisabledProductFromGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitialDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitialDisabledProductFromGridWaitForPageLoad
		$I->click("button[data-action='grid-filter-expand']"); // stepKey: openProductFiltersDisabledProductFromGrid
		$I->fillField("input.admin__control-text[name='sku']", $I->retrieveEntityField('createBundleDynamicProduct', 'sku', 'test')); // stepKey: fillProductSkuFilterDisabledProductFromGrid
		$I->click("button[data-action='grid-filter-apply']"); // stepKey: clickApplyFiltersDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickApplyFiltersDisabledProductFromGridWaitForPageLoad
		$I->see($I->retrieveEntityField('createBundleDynamicProduct', 'sku', 'test'), "//tr[1]//td[count(//div[@data-role='grid-wrapper']//tr//th[normalize-space(.)='SKU']/preceding-sibling::th) +1 ]"); // stepKey: seeProductSkuInGridDisabledProductFromGrid
		$I->click("div[data-role='grid-wrapper'] th.data-grid-multicheck-cell button.action-multicheck-toggle"); // stepKey: openMulticheckDropdownDisabledProductFromGrid
		$I->click("//div[@data-role='grid-wrapper']//th[contains(@class, data-grid-multicheck-cell)]//li//span[text() = 'Select All']"); // stepKey: selectAllProductInFilteredGridDisabledProductFromGrid
		$I->click("div.admin__data-grid-header-row.row div.action-select-wrap button.action-select"); // stepKey: clickActionDropdownDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickActionDropdownDisabledProductFromGridWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-select-wrap')]//ul/li/span[text() = 'Change status']"); // stepKey: clickChangeStatusActionDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickChangeStatusActionDisabledProductFromGridWaitForPageLoad
		$I->click("//div[contains(@class,'admin__data-grid-header-row') and contains(@class, 'row')]//div[contains(@class, 'action-menu-item')]//ul/li/span[text() = 'Disable']"); // stepKey: clickChangeStatusDisabledDisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: waitForStatusToBeChangedDisabledProductFromGrid
		$I->see("A total of 1 record(s) have been updated.", "#messages div.message-success"); // stepKey: seeSuccessMessageDisabledProductFromGrid
		$I->waitForLoadingMaskToDisappear(); // stepKey: waitForMaskToDisappearDisabledProductFromGrid
		$I->conditionalClick(".admin__data-grid-header button[data-action='grid-filter-reset']", ".admin__data-grid-header button[data-action='grid-filter-reset']", true); // stepKey: clickClearFiltersInitial2DisabledProductFromGrid
		$I->waitForPageLoad(30); // stepKey: clickClearFiltersInitial2DisabledProductFromGridWaitForPageLoad
		$I->comment("Exiting Action Group [disabledProductFromGrid] ChangeStatusProductUsingProductGridActionGroup");
		$I->closeTab(); // stepKey: closeTab
		$I->comment("Go to cart page");
		$I->comment("Entering Action Group [openCartPage] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageOpenCartPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedOpenCartPage
		$I->comment("Exiting Action Group [openCartPage] StorefrontCartPageOpenActionGroup");
		$I->comment("Assert checkout button exists on the page");
		$I->seeElement(".action.primary.checkout span"); // stepKey: seeCheckoutButton
		$I->waitForPageLoad(30); // stepKey: seeCheckoutButtonWaitForPageLoad
		$I->comment("Assert no error message is not shown on the page");
		$I->dontSee("Some of the products are out of stock."); // stepKey: seeNoItemsInShoppingCart
	}
}
