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
 * @Title("MC-41079: Add simple product to shopping cart with 'redirect to shopping cart' enabled.")
 * @Description("Verify, user able add simple product to shopping cart from category page and compare products page when 'redirect to shopping cart' is enabled.<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/StorefrontAddSimpleProductToCartWithRedirectToShoppingCartTest.xml<br>")
 * @TestCaseId("MC-41079")
 * @group shoppingCart
 * @group checkout
 */
class StorefrontAddSimpleProductToCartWithRedirectToShoppingCartTestCest
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
		$I->comment("Enable redirect to shopping cart.");
		$enableRedirectToShippingCart = $I->magentoCLI("config:set checkout/cart/redirect_to_cart 1", 60); // stepKey: enableRedirectToShippingCart
		$I->comment($enableRedirectToShippingCart);
		$I->comment("Create test data.");
		$I->createEntity("category", "hook", "_defaultCategory", [], []); // stepKey: category
		$I->createEntity("product", "hook", "SimpleProduct", ["category"], []); // stepKey: product
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Disable redirect to shopping cart.");
		$disableRedirectToShippingCart = $I->magentoCLI("config:set checkout/cart/redirect_to_cart 0", 60); // stepKey: disableRedirectToShippingCart
		$I->comment($disableRedirectToShippingCart);
		$I->comment("Delete test data.");
		$I->deleteEntity("product", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("category", "hook"); // stepKey: deleteCategory
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
	 * @Stories({"Shopping Cart"})
	 * @Features({"Checkout"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function StorefrontAddSimpleProductToCartWithRedirectToShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Try to add simple product to shopping cart.");
		$I->comment("Entering Action Group [goToCategoryPage] StorefrontNavigateToCategoryUrlActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('category', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: goToStorefrontCategoryPageGoToCategoryPage
		$I->comment("Exiting Action Group [goToCategoryPage] StorefrontNavigateToCategoryUrlActionGroup");
		$I->comment("Entering Action Group [addProductToCart] StorefrontAddSimpleProductToCartActionGroup");
		$I->moveMouseOver("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//div[@class='product-item-info']"); // stepKey: moveMouseOverProductAddProductToCart
		$I->click("//main//li[.//a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]]//button[contains(@class, 'tocart')]"); // stepKey: clickAddToCartAddProductToCart
		$I->waitForElementVisible("div.message-success", 30); // stepKey: waitForSuccessMessageAddProductToCart
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'test') . " to your shopping cart.", "div.message-success"); // stepKey: assertSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] StorefrontAddSimpleProductToCartActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: verifyCartRedirectAfterAddingProductFromCategoryPage
		$I->comment("Add product to compare list");
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/" . $I->retrieveEntityField('product', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [addProductToCompare] StorefrontAddProductToCompareActionGroup");
		$I->click("a.action.tocompare"); // stepKey: clickAddToCompareAddProductToCompare
		$I->waitForElement("div.message-success.success.message", 30); // stepKey: waitForAddProductToCompareSuccessMessageAddProductToCompare
		$I->see("You added product " . $I->retrieveEntityField('product', 'name', 'test') . " to the comparison list.", "div.message-success.success.message"); // stepKey: assertAddProductToCompareSuccessMessageAddProductToCompare
		$I->comment("Exiting Action Group [addProductToCompare] StorefrontAddProductToCompareActionGroup");
		$I->comment("Try to add simple product to shopping cart from compare products page.");
		$I->comment("Entering Action Group [checkProductInComparisonList] SeeProductInComparisonListActionGroup");
		$I->amOnPage("catalog/product_compare/index"); // stepKey: navigateToComparePageCheckProductInComparisonList
		$I->waitForPageLoad(30); // stepKey: waitForStorefrontProductComparePageLoadCheckProductInComparisonList
		$I->seeElement("//*[@id='product-comparison']//tr//strong[@class='product-item-name']/a[contains(text(), '" . $I->retrieveEntityField('product', 'name', 'test') . "')]"); // stepKey: seeProductInCompareListCheckProductInComparisonList
		$I->comment("Exiting Action Group [checkProductInComparisonList] SeeProductInComparisonListActionGroup");
		$I->comment("Entering Action Group [addProductToCartFromComparisonList] StorefrontAddSimpleProductToCartFromComparisonListActionGroup");
		$I->waitForElement(".product-item-photo[title='" . $I->retrieveEntityField('product', 'name', 'test') . "']  ~ .product-item-actions button[type='submit']", 30); // stepKey: waitForAddToCartButtonAddProductToCartFromComparisonList
		$I->waitForPageLoad(30); // stepKey: waitForAddToCartButtonAddProductToCartFromComparisonListWaitForPageLoad
		$I->click(".product-item-photo[title='" . $I->retrieveEntityField('product', 'name', 'test') . "']  ~ .product-item-actions button[type='submit']"); // stepKey: clickAddToCartButtonAddProductToCartFromComparisonList
		$I->waitForPageLoad(30); // stepKey: clickAddToCartButtonAddProductToCartFromComparisonListWaitForPageLoad
		$I->waitForElementVisible("div.message-success.success.message", 30); // stepKey: waitForSuccessMessageAddProductToCartFromComparisonList
		$I->see("You added " . $I->retrieveEntityField('product', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: assertSuccessMessageAddProductToCartFromComparisonList
		$I->comment("Exiting Action Group [addProductToCartFromComparisonList] StorefrontAddSimpleProductToCartFromComparisonListActionGroup");
		$I->seeInCurrentUrl("/checkout/cart"); // stepKey: verifyCartRedirectAfterAddingProductFromComparisonList
	}
}
