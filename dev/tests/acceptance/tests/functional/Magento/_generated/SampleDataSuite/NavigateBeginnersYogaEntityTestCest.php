<?php
namespace Magento\AcceptanceTest\_SampleDataSuite\Backend;

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
 * @Title("MC-11955: Should be able to see Beginners Yoga Product")
 * @Description("Should be able to see Beginners Yoga Product created by DownloadableSampleData module<h3>Test files</h3>Users/jessetran/Documents/magento2-sample-data/app/code/Magento/DownloadableSampleData/Test/Mftf/Test/NavigateBeginnersYogaEntityTest.xml<br>")
 * @TestCaseId("MC-11955")
 * @group sampleData
 */
class NavigateBeginnersYogaEntityTestCest
{
	/**
	 * @Features({"DownloadableSampleData"})
	 * @Stories({"Sample data"})
	 * @Severity(level = SeverityLevel::NORMAL)
	 * @Parameter(name = "AcceptanceTester", value="$I")
	 * @param AcceptanceTester $I
	 * @return void
	 * @throws \Exception
	 */
	public function NavigateBeginnersYogaEntityTest(AcceptanceTester $I)
	{
		$I->comment("Entering Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->amOnPage("/beginner-s-yoga.html"); // stepKey: openProductPageOpenProductPage
		$I->waitForPageLoad(30); // stepKey: waitForProductPageLoadedOpenProductPage
		$I->comment("Exiting Action Group [openProductPage] StorefrontOpenProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductName] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->see("Beginner's Yoga", ".base"); // stepKey: seeProductNameAssertProductName
		$I->comment("Exiting Action Group [assertProductName] StorefrontAssertProductNameOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->see("240-LV04", ".product.attribute.sku>.value"); // stepKey: seeProductSkuAssertProductSku
		$I->comment("Exiting Action Group [assertProductSku] StorefrontAssertProductSkuOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->see("$6.00", ".product-info-main [data-price-type='finalPrice']"); // stepKey: seeProductPriceAssertProductPrice
		$I->comment("Exiting Action Group [assertProductPrice] StorefrontAssertProductPriceOnProductPageActionGroup");
		$I->comment("Entering Action Group [assertProductImage] StorefrontAssertProductImagesOnProductPageActionGroup");
		$I->waitForElementNotVisible("#maincontent .fotorama__spinner--show", 30); // stepKey: waitGallerySpinnerDisappearAssertProductImage
		$I->seeElement("[data-gallery-role='gallery']"); // stepKey: seeProductGalleryAssertProductImage
		$I->waitForPageLoad(30); // stepKey: seeProductGalleryAssertProductImageWaitForPageLoad
		$I->seeElement("//*[@data-gallery-role='gallery' and not(contains(@class, 'fullscreen'))]//img[contains(@src, 'lt01.jpg') and not(contains(@class, 'full'))]"); // stepKey: seeProductImageAssertProductImage
		$I->click("//*[@data-gallery-role='gallery' and not(contains(@class, 'fullscreen'))]//img[contains(@src, 'lt01.jpg') and not(contains(@class, 'full'))]"); // stepKey: openFullscreenImageAssertProductImage
		$I->waitForPageLoad(30); // stepKey: waitForGalleryLoadedAssertProductImage
		$I->seeElement("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//img[contains(@src, 'lt01.jpg') and contains(@class, 'full')]"); // stepKey: seeFullscreenProductImageAssertProductImage
		$I->click("//*[@data-gallery-role='gallery' and contains(@class, 'fullscreen')]//*[@data-gallery-role='fotorama__fullscreen-icon']"); // stepKey: closeFullScreenImageAssertProductImage
		$I->waitForPageLoad(30); // stepKey: waitForGalleryDisappearAssertProductImage
		$I->comment("Exiting Action Group [assertProductImage] StorefrontAssertProductImagesOnProductPageActionGroup");
	}
}
