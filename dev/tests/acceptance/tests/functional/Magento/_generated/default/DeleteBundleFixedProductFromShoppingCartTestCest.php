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
 * @Title("MC-14690: Delete bundle fixed product from shopping cart test")
 * @Description("Delete bundle fixed product from shopping cart<h3>Test files</h3>app/code/Magento/Checkout/Test/Mftf/Test/DeleteBundleFixedProductFromShoppingCartTest.xml<br>")
 * @TestCaseId("MC-14690")
 * @group checkout
 * @group mtf_migrated
 */
class DeleteBundleFixedProductFromShoppingCartTestCest
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
		$I->comment("Create simple product");
		$I->createEntity("createSimpleProduct", "hook", "SimpleProduct2", [], []); // stepKey: createSimpleProduct
		$I->comment("Create bundle product");
		$I->createEntity("createFixedBundleProduct", "hook", "ApiFixedBundleProduct", [], []); // stepKey: createFixedBundleProduct
		$I->createEntity("createBundleOption", "hook", "DropDownBundleOption", ["createFixedBundleProduct"], []); // stepKey: createBundleOption
		$I->createEntity("addLinkOptionToBundleProduct", "hook", "ApiBundleLink", ["createFixedBundleProduct", "createBundleOption", "createSimpleProduct"], []); // stepKey: addLinkOptionToBundleProduct
		$I->comment("Entering Action Group [reindex] CliIndexerReindexActionGroup");
		$reindexSpecifiedIndexersReindex = $I->magentoCLI("indexer:reindex", 60, "cataloginventory_stock"); // stepKey: reindexSpecifiedIndexersReindex
		$I->comment($reindexSpecifiedIndexersReindex);
		$I->comment("Exiting Action Group [reindex] CliIndexerReindexActionGroup");
	}

	/**
	  * @param AcceptanceTester $I
	  * @throws \Exception
	  */
	public function _after(AcceptanceTester $I)
	{
		$I->comment("Delete bundle product data");
		$I->deleteEntity("createSimpleProduct", "hook"); // stepKey: deleteSimpleProduct
		$I->deleteEntity("createFixedBundleProduct", "hook"); // stepKey: deleteFixedBundleProduct
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
	 * @Stories({"Delete Products from Shopping Cart"})
	 * @Severity(level = SeverityLevel::CRITICAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function DeleteBundleFixedProductFromShoppingCartTest(AcceptanceTester $I)
	{
		$I->comment("Go to bundle product page");
		$I->amOnPage("/" . $I->retrieveEntityField('createFixedBundleProduct', 'custom_attributes[url_key]', 'test') . ".html"); // stepKey: navigateToProductPage
		$I->waitForPageLoad(30); // stepKey: waitForPageLoad
		$I->comment("Add product to the cart");
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
		$I->see("You added " . $I->retrieveEntityField('createFixedBundleProduct', 'name', 'test') . " to your shopping cart.", "div.message-success.success.message"); // stepKey: seeAddToCartSuccessMessageAddProductToCart
		$I->comment("Exiting Action Group [addProductToCart] AddToCartFromStorefrontProductPageActionGroup");
		$I->comment("Remove product from cart");
		$I->comment("Entering Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->amOnPage("/checkout/cart"); // stepKey: openCartPageGoToCart
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadedGoToCart
		$I->comment("Exiting Action Group [goToCart] StorefrontCartPageOpenActionGroup");
		$I->comment("Entering Action Group [deleteProduct] DeleteProductFromShoppingCartActionGroup");
		$I->click("//*[contains(text(), '" . $I->retrieveEntityField('createFixedBundleProduct', 'name', 'test') . "')]/ancestor::tbody//a[@class='action action-delete']"); // stepKey: deleteProductFromCheckoutCartDeleteProduct
		$I->waitForPageLoad(30); // stepKey: deleteProductFromCheckoutCartDeleteProductWaitForPageLoad
		$I->waitForPageLoad(30); // stepKey: waitForPageLoadDeleteProduct
		$I->see("You have no items in your shopping cart."); // stepKey: seeNoItemsInShoppingCartDeleteProduct
		$I->comment("Exiting Action Group [deleteProduct] DeleteProductFromShoppingCartActionGroup");
	}
}
